<?php
namespace App\Controller;

class ChatbotController extends AppController
{
    /**
     * Afficher la page du chatbot
     */
    public function index(): void
    {
        $this->set('title', 'Assistant CRM');
    }

    /**
     * Recevoir une question et retourner une réponse JSON
     */
    public function reply(): void
    {
        $this->request->allowMethod(['post']);

        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption(
            'serialize',
            ['success', 'response']
        );

        $message = trim(
            (string)$this->request->getData('message')
        );

        if ($message === '') {
            $this->set([
                'success' => false,
                'response' => 'Message vide.'
            ]);
            return;
        }

        try {
            $response = $this->_resolveMessage($message);

            $this->set([
                'success' => true,
                'response' => $response
            ]);

        } catch (\Throwable $e) {

            $this->log(
                'Erreur Chatbot : ' . $e->getMessage(),
                'error'
            );

            $this->set([
                'success' => false,
                'response' => 'Une erreur est survenue : ' .
                    $e->getMessage()
            ]);
        }
    }

    /**
     * Détecter le type de question
     */
    private function _resolveMessage(string $message): string
    {
        $message = mb_strtolower($message);

        // Vérifier si la question demande un nombre
        $isCountQuestion = preg_match(
            '/\b(combien|nombre|total|count|how many|how much|nbre)\b/u',
            $message
        );

        // Questions sur les prospects
        if (str_contains($message, 'prospect')) {

            if ($isCountQuestion) {
                return $this->_count(
                    'Prospects',
                    'prospect(s) dans la base'
                );
            }

            return $this->_askOllama($message);
        }

        // Questions sur les clients
        if (str_contains($message, 'client')) {

            if ($isCountQuestion) {
                return $this->_count(
                    'Clients',
                    'client(s) enregistré(s)'
                );
            }

            return $this->_askOllama($message);
        }

        // Questions sur les appels
        if (
            str_contains($message, 'call') ||
            str_contains($message, 'appel')
        ) {

            if ($isCountQuestion) {
                return $this->_count(
                    'Calls',
                    'appel(s) enregistré(s)'
                );
            }

            return $this->_askOllama($message);
        }

        // Recherche dans la base de connaissances
        $knowledgeResponse = $this->_searchKnowledgeBase($message);

        if ($knowledgeResponse !== null) {
            return $knowledgeResponse;
        }

        // Questions générales : Ollama AI
        return $this->_askOllama($message);
    }

    /**
     * Compter les enregistrements dans la base de données
     */
    private function _count(
        string $table,
        string $label
    ): string {

        $count = $this->fetchTable($table)
            ->find()
            ->count();

        return sprintf(
            '%d %s.',
            $count,
            $label
        );
    }

    /**
     * Rechercher une réponse dans la table Chatbot
     */
    private function _searchKnowledgeBase(
        string $message
    ): ?string {

        $result = $this->fetchTable('Chatbot')
            ->find()
            ->where([
                'question LIKE' => '%' . $message . '%'
            ])
            ->select(['reponse'])
            ->first();

        if ($result && !empty($result->reponse)) {
            return $result->reponse;
        }

        return null;
    }

    /**
     * Envoyer la question à Ollama AI
     */
    private function _askOllama(string $message): string
    {
        $url = 'http://localhost:11434/api/chat';

        $data = [
            'model' => 'qwen2.5:3b',
            'stream' => false,

            'messages' => [
                [
                    'role' => 'system',
                    'content' =>
                        'Tu es un assistant intelligent intégré dans un CRM commercial. ' .
                        'Tu aides les utilisateurs à comprendre les fonctionnalités CRM. ' .
                        'Tu réponds aux questions sur les prospects, les clients et les appels. ' .
                        'Tu peux aussi répondre aux questions générales en informatique. ' .
                        'Réponds clairement et simplement en français. ' .
                        'Ne prétends jamais connaître les données réelles de la base CRM. ' .
                        'Ne donne pas de nombres inventés concernant les clients ou les prospects.'
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ]
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,

            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],

            CURLOPT_POSTFIELDS => json_encode($data),

            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 180
        ]);

        $result = curl_exec($ch);

        if ($result === false) {

            $error = curl_error($ch);

            curl_close($ch);

            throw new \RuntimeException(
                'Connexion à Ollama impossible : ' . $error
            );
        }

        $httpCode = curl_getinfo(
            $ch,
            CURLINFO_HTTP_CODE
        );

        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \RuntimeException(
                'Erreur API Ollama : HTTP ' . $httpCode
            );
        }

        $response = json_decode($result, true);

        if (!isset($response['message']['content'])) {
            throw new \RuntimeException(
                'Réponse invalide de Ollama.'
            );
        }

        return trim(
            $response['message']['content']
        );
    }
}
