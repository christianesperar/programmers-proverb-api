<?php namespace ChristianEsperar\ProgrammersProverbsApi;

class ProgrammersProverbsApi
{

   /**
     * Main method of the API
     *
     * @param string $view
     * @return string
     */
    public function getProverb($view = 'random')
    {
        $proverbs = $this->getReadMe();
        $proverbs = $this->decodeBase64($proverbs['body']['content']);
        $proverbs = $this->returnView($proverbs, $view);
        $proverbs = $this->isJSONP($proverbs);

        return $this->returnOutput($proverbs);
    }

    /**
      * Get README contents base on GitHub API
      *
      * @return array
      */
    protected function getReadMe()
    {
        $ch = curl_init('https://api.github.com/repos/AntJanus/programmers-proverbs/contents/README.md');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json'
        ));
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        list($header, $body) = explode("\r\n\r\n", $response, 2);
        curl_close($ch);

        return [
            'header' => $header,
            'body' => json_decode($body, true)
        ];
    }

    /**
      * Decode README content as string which is initially base on Base64
      *
      * @param string $string
      * @return string
      */
    protected function decodeBase64($string)
    {
        return base64_decode($string);
    }

    /**
      * Return view base on user settings
      *
      * @param string $proverbs
      * @param string $view
      * @return string
      */
    protected function returnView($proverbs, $view)
    {
        preg_match_all('/#### (.*)\n/U', $proverbs, $match);

        switch ($view) {
            case 'all':
                return $match[1];
            case 'random':
                return $match[1][array_rand($match[1], 1)];
        }
    }

    /**
     * Return view base on user settings
     *
     * @param string $proverbs
     * @return string
     */
    protected function isJSONP($proverbs)
    {
        $proverbs = json_encode($proverbs);

        return isset($_GET['callback']) ? $_GET['callback']."(".$proverbs.")" : $proverbs;
    }

    /**
     * Return output base on user request
     *
     * @param string $proverbs
     * @return string
     */
    protected function returnOutput($proverbs)
    {
        if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH') === 'xmlhttprequest') {
            echo $proverbs;
        } else {
            return $proverbs;
        }
    }
}
