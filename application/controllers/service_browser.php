<?php
class service_browser extends CI_Controller {
    
    public function index() {
        
        $cwd = basename(__DIR__);
        $arrTmpApiController = array();
        foreach (glob(APPPATH . $cwd . '/api_*.php') as $filename) {
            $arrTmpApiController[] = basename($filename, '.php');
        }
        
        $data['apiControllers'] = $arrTmpApiController;
        $data['submission_method'] = null;
        $data['method_params'] = array();
        $data['selectedClass'] = $data['selectedMethod'] = '';
        
        
        // get methods if there is selected class
        $apiClass = $this->input->get_post('signature');
        if (!empty($apiClass)) {
            require APPPATH . 'controllers/' . $apiClass . '.php';
            
            $data['selectedClass'] = $apiClass;
            $objReflection = new ReflectionClass($apiClass);
            $methods = $objReflection->getMethods();
            foreach ($methods as $objMethod) {
                $method = $objMethod->name;
                if ($method[0] !== '_' && (strpos($method,'_get') || strpos($method,'_put') || strpos($method,'_delete') || strpos($method,'_post'))) 
                {
                    $data['apiMethods'][$apiClass][$method] = $method;        
                }
            }
            
            
            // selected method
            $selectedMethod = $this->input->get_post('method');
            if (!empty($selectedMethod)) {
                
            	$data['selectedMethod'] = $selectedMethod;
                $objReflectionMethod = new ReflectionMethod($apiClass, $selectedMethod);
                $comment = $objReflectionMethod->getDocComment();
                
    			$pieces = explode("\n", $comment);
    			$params = array();
    			$multipart = false;
    			$submission_method = '';
    			foreach($pieces as $p) {
    				$fixed = preg_replace('/\s*\*\s*/', '', $p);
    				
    				if(preg_match('/@param\s+([\w()]*)\s+(\w*)\s*(.*)/', $fixed, $matches)) {
    				
    					$params[] = array('name' => $matches[2], 
    										'type' => $matches[1],
    										'description' => $matches[3]);
    					if ($matches[1] == 'file') {
    						$multipart = true;
    					}
    				}
    				
    				if(preg_match('/@method\s+(post|get)/i', $fixed, $matches)) {
    					$submission_method = $matches[1];
    					$data['submission_method'] = $submission_method;
    				}
    			}
                
    		    $data['method_params'] = $params;
    		    if ($multipart) {
				    $data['multipart'] = 'enctype="multipart/form-data"';
    		    }
    			$url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $apiClass . '/' . $selectedMethod;
    			$inputMethod = $this->input->get_post('_method');
    			$isPost = $inputMethod === 'post' ? true : false;
    			$post = (!empty($inputMethod) && $isPost) ? $this->input->post() : $this->input->get();
    			unset($post['_method'], $post['_submit']);
    			if (!empty($inputMethod)) {
    			    $clientClass = strtolower($apiClass) . '_client';
    			    $this->load->library('clients/'. $clientClass);
    			    $result = $this->$clientClass->$selectedMethod($post, $isPost, 'application/json');
    			    $data['result'] = $result;
    			}
            }
        }
        
        $this->load->view('service_browser', $data);
        
    }
    
    public function generate_client() {
        $cwd = basename(__DIR__);
        $arrTmpApiController = array();
        foreach (glob(APPPATH . $cwd . '/api_*.php') as $filename) {
            $arrTmpApiController[] = basename($filename, '.php');
        }
        $arrSelectedControllers = $this->input->post('selectedApiController');
        $arrClientFileGenerated = array();
        if (!empty($arrSelectedControllers)) {
            $clientDir = APPPATH . 'libraries/clients/';
            foreach ($arrSelectedControllers as $apiController) {
                require_once APPPATH . 'controllers/' . $apiController . '.php';
                $clientFile = $clientDir . $apiController . '_client.php';
                $apiName = $apiController . '_client';
                $objSelectedApiController = new ReflectionClass($apiController);
                ob_start();
    			include(APPPATH . 'bin/templates/api_client.php');
    			$file_contents = ob_get_clean();
    			file_put_contents($clientFile, $file_contents);
    			$arrClientFileGenerated[] = $clientFile;
            }
            
            $data['arrClientFileGenerated'] = $arrClientFileGenerated;
        }
        
        $data['apiControllers'] = $arrTmpApiController;
        $this->load->view('generate_client', $data);
    }
    
} 