<?php 

        class WebServiceAutoLoad{
            private $path = '';
            private $name = 'WebServiceAutoLoad';
            private $file ;
            private $url = '/Index/getinterface';
            private $testdomain = 'http://dev01.ports-intl.com';
            private $domain = 'http://webservice.ports-intl.com';
            function __construct($version=''){
                
                $rand = date('Y-m-d');
                $this->path = sys_get_temp_dir ();
                $this->file = $this->path.'/'.$this->name.'.'.$rand.'.tmp';
                if(strtolower($version) == 'test' || strtolower($version) == 'hj'){
                    $this->domain = $this->testdomain;
                }
                $this->url = $this->domain.$this->url;
                if(is_file($this->file)){
                    if(@eval(file_get_contents($this->file))===false){
                        @unlink($this->file);
                        $this->Write(true);
                    }elseif(rand(0, 10)==5){
                        $this->Write();
                    }
                }else{
                    $this->Write(true);
                    @unlink($this->path.'/'.$this->name.'.'.date('Y-m-d',time()-86400)).'.tmp';
                }
            }
            function Write($run=false){
                global $_GLOBAL;
                $file = file_get_contents($this->url);
                if('WebServiceVersion' == substr($file, 2,17)
                        && $_GLOBAL['getWebServiceVersion']!=substr($file,20,10)){
                    if(@$fp = fopen($this->file, 'w')) {
                        fwrite( $fp , $file );fclose( $fp );
                        if($run){
                            @eval($file);
                        }
                    }
                }elseif('WebServiceVersion' != substr($file, 2,17)){
                    $ch_curl = curl_init ();
                    curl_setopt ( $ch_curl, CURLOPT_TIMEOUT, 20);//3s
                    curl_setopt ( $ch_curl, CURLOPT_HEADER, false );
                    $head = curl_getinfo($ch_curl);
                    $error .= ("-----------Curl Error----------"."\r\n");
                    $error .= ("WebService Upgrade Error. Please Check AutoUpdate Api. Referer:{$this->url}\r\n");
                    $error .= ("API Reponse Text: {$file}\r\n");
                    $error .= ("-----------Curl Error End----------");
                    curl_setopt ( $ch_curl, CURLOPT_POST , 1);
                    curl_setopt ( $ch_curl, CURLOPT_POSTFIELDS , http_build_query(array('error'=>$error)));
                    curl_setopt ( $ch_curl, CURLOPT_URL, $this->domain.'/Plugin/Log' );
                    curl_exec ( $ch_curl );
                }
            }
        }
        

new WebServiceAutoLoad(C('WS_CONFIG_HOST'));
?>