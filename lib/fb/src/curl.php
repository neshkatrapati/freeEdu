<?php
class CurlHelper
{
  /**
   * Downloads a file from a url and returns the temporary file path.
   * @param string $url
   * @return string The file path
   */
  public static function downloadFile($url, $options = array(),$imgfile)
  {
    if (!is_array($options))
      $options = array();
    $options = array_merge(array(
        'connectionTimeout' => 5, // seconds
        'timeout' => 10, // seconds
        'sslVerifyPeer' => false,
        'followLocation' => false, // if true, limit recursive redirection by
        'maxRedirs' => 1, // setting value for "maxRedirs"
        ), $options);

    // create a temporary file (we are assuming that we can write to the system's temporary directory)
    $tempFileName = $imgfile;
    $fh = fopen($tempFileName, 'w');

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_FILE, $fh);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $options['connectionTimeout']);
    curl_setopt($curl, CURLOPT_TIMEOUT, $options['timeout']);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $options['sslVerifyPeer']);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $options['followLocation']);
    curl_setopt($curl, CURLOPT_MAXREDIRS, $options['maxRedirs']);
    curl_exec($curl);

    curl_close($curl);
    fclose($fh);

    return $tempFileName;
  }


}?>