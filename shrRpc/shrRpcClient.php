<?php

define("SHR_PROCEDURE_NAME_PARAM", "procedureName");
define("SHR_PROCEDURE_NAME_RESULT", "Result");
define("SHR_PROCEDURE_PARAMS", "params");

require_once 'XML/RPC.php';

/**
	Provides Shirtinator WebService Client.
	This is the basic class used to represent a client of a Shirtinator Web Services.

	@access		public
	@version 	1.0.2, 25.05.2007
	@package	Service.Client
*/
class shrRpcClient {
	/**
	@access	public; @const _XMLRPC_SERVER;
	*/
	//const _XMLRPC_SERVER = "http://shirt-test.shirtinator.de";
	const _XMLRPC_SERVER = "http://www.shirtinator.de";
//	const _XMLRPC_SERVER = "http://shirtinator.shirtinator.net";

	
	/**
	@access	public; @const _VALUE_TYPE_INT;
	*/
	const _VALUE_TYPE_INT = "int";
	
	/**
	@access	public; @const _VALUE_TYPE_STRING;
	*/
	const _VALUE_TYPE_STRING = "string";
	
	/**
	@access	public; @const _VALUE_TYPE_STRUCT;
	*/
	const _VALUE_TYPE_STRUCT = "struct";
	
	/**
	@access	public; @const _VALUE_TYPE_ARRAY;
	*/
	const _VALUE_TYPE_ARRAY = "array";
	
	/**
	@access	public; @const _XMLRPC_SERVICE;
	*/
	const _XMLRPC_SERVICE = "/xmlrpc.service.php";
	
	/**
		@var	string
		@access	private
	*/
	var $__userID;
	
	/**
		@var	string
		@access	private
	*/
	var $__shopId;
	
	/**
		@var	string
		@access	private
	*/
	var $__creatorId;
	
	/**
		@var	object 	XML_RCP_Client
		@access	private
	*/
	var $__rpcClient;
	
	/**
		@var	array
		@access	private
	*/
	var $__rpcRequestValues;
	
	/**
		@var	object XML_RPC_Response
		@access	public
	*/
	var $_lastResponse;
	
	/**
		@var	object XML_RPC_Value
		@access	public
	*/
	var $_lastResponseValue;
	
	/**
		@var	string
		@access	public
	*/
	var $_authorizationID;
	
	/**
		@var	object XML_RPC_Message
		@access	public
	*/
	var $_procedureCallMessage;
	
	/**
		@var	string
		@access	private
	*/
	var $__serializedGetArray;
	
	/**
		@var	string
		@access	private
	*/
	var $__serializedPostArray;
	
	/**
		@var	string
		@access	private
	*/
	var $__responseStructure;
	
	/**
		@var	int
		@access	private
	*/
	var $__procedureCounter;

	/**
	 	Creates a new instance of ServiceClient Class.
		@access	public
	*/
	function shrRpcClient() {
		$this->__serializedGetArray = $this->getSerializedArray($_GET);
		$this->__serializedPostArray = $this->getSerializedArray($_POST);

		$this->__rpcClient = new XML_RPC_Client(self::_XMLRPC_SERVICE, self::_XMLRPC_SERVER);
		$this->_procedureCallMessage = new XML_RPC_Message('Service.procedureCall()');
		$this->clearRequestStack();
	}
	
	// method: setShopId;
	public function setShopId($shopId) {
		$this->__shopId = $shopId;
	}
	
	// method: setCreatorId;
	public function setCreatorId($creatorId) {
		$this->__creatorId = $creatorId;
	}

	/**
	 	Converts Array to a serialized String.
		
		@access		private
		@return		string
		@param		array $getArr
	*/
	function getSerializedArray($getArr) {
		$serialString = urlencode(serialize($getArr));
		return $serialString;
	}
	
	/**
	 	Adds request parameter to the requests stack.
		
		@access		public
		@param		string $name
		@param		string $value
		@param		string $type
		@see		clearRequestStack();
	*/
	function addRequestParam($name, $value, $type) {
		$newStructVal = new StructuredValue($name, $value, $type);
		array_push($this->__rpcRequestValues, $newStructVal);
	}
	
	function addRequest($procedureName, $params="") {
		$this->addRequestParam(SHR_PROCEDURE_NAME_PARAM."#".$this->__procedureCounter, $procedureName, self::_VALUE_TYPE_STRING);
		$this->addRequestParam(SHR_PROCEDURE_PARAMS."#".$this->__procedureCounter, $this->getSerializedArray($params), self::_VALUE_TYPE_STRING);
		$this->__procedureCounter++;
	}
	
	/**
	 	Resets requests stack.
		
		@access		public
		@see		clearRequestStack();
	*/
	function clearRequestStack() {
		$this->_procedureCallMessage = new XML_RPC_Message('Service.procedureCall()');
		$this->__rpcRequestValues = array();
		$this->__procedureCounter = 0;
	}
	
	/**
	 	Sends prepared request to the WebServices Server.
		if success, Service->_lastResponseValue is filled with returned StructuredValue Object.
		
		@access		public
		@param 		object XML_RPC_Request $rpcRequest
	*/
	function sendRequest($rpcRequest=0) {
		// add standard params;
		if ($rpcRequest==0) {
			$rpcRequest = $this->_procedureCallMessage;
		}
		$this->addRequestParam("shopID", $this->__shopId, self::_VALUE_TYPE_STRING);
		$this->addRequestParam("creatorID", $this->__creatorId, self::_VALUE_TYPE_STRING);
		$this->addRequestParam("getArray", $this->__serializedGetArray, self::_VALUE_TYPE_STRING);
		$this->addRequestParam("postArray", $this->__serializedPostArray, self::_VALUE_TYPE_STRING);

		$this->addRequestParam("authorizationID", $_SESSION['RPC']['authorizationID'], self::_VALUE_TYPE_STRING);
		$this->addRequestParam("clientSessionId", session_id(), self::_VALUE_TYPE_STRING);
		$this->addRequestParam("clientSessionName", session_name(), self::_VALUE_TYPE_STRING);
		
		
		$valuesArray = array();
		for ($i=0; $i<count($this->__rpcRequestValues); $i++) {
			$structuredValue =  $this->__rpcRequestValues[$i];
			$valName = $structuredValue->_name;
			$valValue = $structuredValue->_value;
			$valType = $structuredValue->_type;
			$valuesArray[$valName] = new XML_RPC_Value($valValue, $valType);
		}
		$myRequestValue = new XML_RPC_Value($valuesArray, self::_VALUE_TYPE_STRUCT);
		
		$rpcRequest->addParam($myRequestValue);
		//$this->__rpcClient->setDebug(1);
		
		// only for dev server;
		//$this->__rpcClient->setCredentials("andy", "Luchava2005");
		
		
		$this->_lastResponse = $this->__rpcClient->send($rpcRequest);
		if ($this->checkResponse($this->_lastResponse)) {
			$this->_lastResponseValue = $this->_lastResponse->value();;
			
			// authorization;
			if (!$this->_lastResponse->faultCode()) {
				$this->_authorizationID = $this->getScalarFromResponseStruct("service_authorizationId");
				$_SESSION['RPC']['authorizationID'] = $this->_authorizationID;
				
				// proces response structure;
				$this->processResponse();
			}
		}
		$this->clearRequestStack();
	}
	
	/**
	 	Standard communication verifier. 
		If the communication between client and server fails returns false, otherwise return true.
		
		@access		public
		@param 		object XML_RPC_Response $rpcResponse
	*/
	function checkResponse($rpcResponse) {
		if (!$rpcResponse) {
			// some comm error;
			echo 'Communication error: ' . $this->__rpcClient->errstr;
			return false;
		}
		return true;
	}
	
	/**
	 	Response processor.
		
		@access		private
		@return		void
	*/
	function processResponse() {
		// clear stack;
		$this->__responseStructure = array();
		
		while($param = $this->_lastResponseValue->structeach()) {
			$responseParamName = $param[0];
			$paramNameArr = explode("@", $responseParamName);
			if (count($paramNameArr) > 1) {
				$paramName = $paramNameArr[0];
				$procedureName = $paramNameArr[1];
				
				$procedureSectionName = $procedureName.SHR_PROCEDURE_NAME_RESULT;
				if (!isset($this->__responseStructure[$procedureSectionName])) {
					$this->__responseStructure[$procedureSectionName] = array();
				}
				$this->__responseStructure[$procedureSectionName][$paramName] = $this->getScalarFromResponseStruct($responseParamName);
			}
		}
		
		//print_r($this->__responseStructure);
	}
	
	/**
		Returns the _value property from last responded StructuredValue Object.
		
		@access		public
		@param 		string $name The name property of StructuredValue object.
		@return		string
	*/
	function getScalarFromResponseStruct($name) {
		$rpcValue = $this->_lastResponseValue->structmem($name);

		if ($this->_lastResponseValue->isValue($rpcValue)) {
			$scalar = $rpcValue->scalarval();
			return $scalar;
		}
	}
	
	function getResponse($procedureName) {
		$procedureSectionName = $procedureName.SHR_PROCEDURE_NAME_RESULT;
		if (isset($this->__responseStructure[$procedureSectionName])) {
			return $this->__responseStructure[$procedureSectionName];
		}
	}
	
}

// class: StructuredValue;
class StructuredValue {
	var $_name;
	var $_value;
	var $_type;
	
	function StructuredValue($name, $value, $type) {
		$this->_name = $name;
		$this->_value = $value;
		$this->_type = $type;
	}
}
if (!isset($_SESSION)) {
	session_start();
}
if (!isset($_SESSION['RPC'])) {
	$_SESSION['RPC'] = array();
}
?>
