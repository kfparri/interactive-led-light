<?php

class CommandController extends BaseController 
{
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($requestMethod) == 'GET')
        {
            try 
            {
                $commandModel = new CommandModel();

                $intLimit = 10;
                if(isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit'])
                {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                
                $arrCommands = $commandModel->GetCommands($intLimit);
                $responseData = json_encode($arrCommands);
            }
            catch(Exception $ex)
            {
                $strErrorDesc = $ex->getMessage() . ' Something went wrong!  Please help!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = "Method not supported";
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if(!$strErrorDesc)
        {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        else
        {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function listNewAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($requestMethod) == 'GET')
        {
            try 
            {
                $commandModel = new CommandModel();

                $intLimit = 10;
                if(isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit'])
                {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                
                $arrCommands = $commandModel->getUnproccesdCommands();
                $responseData = json_encode($arrCommands);
            }
            catch(Exception $ex)
            {
                $strErrorDesc = $ex->getMessage() . ' Something went wrong!  Please help!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = "Method not supported";
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if(!$strErrorDesc)
        {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        else
        {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function updateAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $apiKey = $this->getPostParam('api_key');
        $postParam = $this->getPostParam('id');

        if(strtoupper($requestMethod) == 'POST')
        {
            try 
            {
                $commandModel = new CommandModel();

                if($commandModel->isAuthorized($apiKey))
                {
                    $id = -1;
                    if(isset($postParam))
                    {
                        $id = $postParam;
                    }
                    
                    $arrCommands = $commandModel->updateCommand($id);
                    $responseData = json_encode($arrCommands);

                    $commandModel->updateApiKeyUsed($apiKey);
                }
                else
                {
                    $strErrorDesc = 'You are not authorized';
                    $strErrorHeader = 'HTTP/1.1 401 Unauthorized';
                }
            }
            catch(Exception $ex)
            {
                $strErrorDesc = $ex->getMessage() . ' Something went wrong!  Please help!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = "Method not supported";
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if(!$strErrorDesc)
        {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        else
        {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function insertAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $apiKey = $this->getPostParam('api_key');
        $postParam = $this->getPostParam('command');

        if(strtoupper($requestMethod) == 'POST')
        {
            try 
            {
                $commandModel = new CommandModel();

                if($commandModel->isAuthorized($apiKey))
                {
                    $command = "0,0,0";
                    if(isset($postParam))
                    {
                        $command = $postParam;
                    }
                    
                    $arrCommands = $commandModel->insertCommand($command);
                    $responseData = json_encode($arrCommands);

                    $commandModel->updateApiKeyUsed($apiKey);
                }
                else
                {
                    $strErrorDesc = 'You are not authorized';
                    $strErrorHeader = 'HTTP/1.1 401 Unauthorized';
                }
            }
            catch(Exception $ex)
            {
                $strErrorDesc = $ex->getMessage() . ' Something went wrong!  Please help!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = "Method not supported";
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if(!$strErrorDesc)
        {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        else
        {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}