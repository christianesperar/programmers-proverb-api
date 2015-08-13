<?php
class ProgrammersProverbsApi {

   /**
     * Main method of the API
     * 
     * @param string $view
     * @return string
     */
    public function getProverb($view = 'random')
    {
        header('Content-Type: application/json');

        $proverbs = $this->_getReadMe();
        $proverbs = $this->_decodeBase64($proverbs['body']['content']);
        $proverbs = $this->_returnView($proverbs, $view);

        echo json_encode($proverbs);
    }

   /**
     * Get ReadMe contents base on GitHub API
     * 
     * @return string
     */
    protected function _getReadMe() {
        $ch = curl_init('https://api.github.com/repos/AntJanus/programmers-proverbs/contents/README.md');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,'PHP');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json'
        ));
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        list($header, $body) = explode("\r\n\r\n", $response, 2);
        curl_close($ch);
        return array('header' => $header, 'body' => json_decode($body, true));
    }

   /**
     * Decode ReadMe content as string which is initia;; base on Base64
     * 
     * @param string $string
     * @return string
     */
    protected function _decodeBase64($string) {
        return base64_decode($string);
    }

   /**
     * Return view base on user settings
     * 
     * @param string $proverbs
     * @param string $view
     * @return string
     */
    protected function _returnView($proverbs, $view) {
        preg_match_all('/####(.*)\n/U', $proverbs, $match);

        switch ($view) {
            case 'all':
                return $match[1];
            case 'random':
                return $match[1][array_rand($match[1],1)];
        }
    }
}