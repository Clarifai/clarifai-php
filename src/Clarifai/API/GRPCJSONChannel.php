<?php
namespace Clarifai\API;

class JSONUnaryUnary
{
    // This mimics the unary_unary calls and is actually the thing doing the http requests.

    public function __constructor($key, $urlTemplate, $method, $requestMessageDescriptor,
        $requestSerializer, $responseDeserializer)
    {
        /*
        Args:
          key: a string api key to use in the {"Authorization": "Key %s" % key} headers to send in each
        request.
          url_template: the url template for this method.
          method: the HTTP method to use for this request.
          input_type: this is a MessageDescriptor for the input type.
          request_serializer: the method to use to serialize the request proto
          response_deserializer: the response proto deserializer which will be used to convert the http
            response will be parsed into this.

        Returns:
          response: a proto object of class response_deserializer filled in with the response.
        */
        $this->key = key;
        $this->urlTemplate = urlTemplate;
        $this->method = method;
        $this->requestMessageDescriptor = requestMessageDescriptor;
        $this->requestSerializer = requestSerializer;
        $this->responseDeserializer = responseDeserializer;
        $this->headers = ["Authorization" => "Key " . key];
//    $this->_url_regex = re.compile(r'\{{1}(.*?)\}{1}');
    }

//  def _url_params(self, request_dict):
//    """ This converts fills in the url template for this request with actual url safe params from
//    the request body.
//    Args:
//      request_dict: a dictionary form of the request from json_format.MessageToDict(request,
//        preserving_proto_field_name=True) so that we can recursively lookup url params.
//    Returns:
//      url: the url string to use in requests.
//    """
//    url = self.url_template
//    for match in re.findall(self._url_regex, self.url_template):
//      # match will be something like pagination.page
//      fields = match
//      getter = request_dict
//      # recurse through the object dict and use get() which will fail if any url param is not set.
//      for field in fields.split('.'):
//        getter = request_dict.get(field)
//        if getter is None:
//          raise Exception("You must set the following fields in your request proto: %s" % fields)
//      # finally replace in the url the result of the recursive getting.
//      url = url.replace('{' + match + '}', getter)
//    return url

//  def __call__(self, request, metadata=None):
//    """ This is where the actually calls come through when the stub is called such as
//    stub.PostInputs(). They get passed to this method which actually makes the request.
//
//    Args:
//      request: the proto object for the request. It must be the proper type for the request or the
//        server will complain. Note: this doesn't type check the incoming request in the client but
//        does make sure it can serialize before sending to the server atleast.
//      metadata: not used currently, just added to match grpc.
//
//    Returns:
//      response: the proto object that this method returns.
//    """
//
//    # There is no __self__ attribute on the request_serializer unfortunately.
//    expected_object_name = self.request_message_descriptor.name
//    if type(request).__name__ != expected_object_name:
//      raise Exception("The input request must be of type: %s from %s" %
//                      (expected_object_name, self.request_message_descriptor.file.name))
//
//    params = MessageToDict(
//        request, preserving_proto_field_name=True, including_default_value_fields=True)
//
//    if metadata is not None:
//      raise Exception("No support currently for metadata field.")
//
//    # Convert the url template to a proper url.
//    url = self._url_params(params)
//
//    if self.method == 'GET':
//      headers = {
//          'Content-Type': 'application/json',
//          'X-Clarifai-Client': 'python:%s' % CLIENT_VERSION,
//          'Python-Client': '%s:%s' % (OS_VER, PYTHON_VERSION),
//          'Authorization': self.headers['Authorization']
//      }
//      res = requests.get(url, params=params, headers=headers)
//    elif self.method == "POST":
//      headers = {
//          'Content-Type': 'application/json',
//          'X-Clarifai-Client': 'python:%s' % CLIENT_VERSION,
//          'Python-Client': '%s:%s' % (OS_VER, PYTHON_VERSION),
//          'Authorization': self.headers['Authorization']
//      }
//      res = requests.post(url, data=json.dumps(params), headers=headers)
//    elif self.method == "DELETE":
//      headers = {
//          'Content-Type': 'application/json',
//          'X-Clarifai-Client': 'python:%s' % CLIENT_VERSION,
//          'Python-Client': '%s:%s' % (OS_VER, PYTHON_VERSION),
//          'Authorization': self.headers['Authorization']
//      }
//      res = requests.delete(url, data=json.dumps(params), headers=headers)
//    elif self.method == "PATCH":
//      headers = {
//          'Content-Type': 'application/json',
//          'X-Clarifai-Client': 'python:%s' % CLIENT_VERSION,
//          'Python-Client': '%s:%s' % (OS_VER, PYTHON_VERSION),
//          'Authorization': self.headers['Authorization']
//      }
//      res = requests.patch(url, data=json.dumps(params), headers=headers)
//    elif self.method == "PUT":
//      headers = {
//          'Content-Type': 'application/json',
//          'X-Clarifai-Client': 'python:%s' % CLIENT_VERSION,
//          'Python-Client': '%s:%s' % (OS_VER, PYTHON_VERSION),
//          'Authorization': self.headers['Authorization']
//      }
//      res = requests.put(url, data=json.dumps(params), headers=headers)
//    else:
//      raise Exception("Unsupported request type: '%s'" % self.method)
//
//    # Get the actual message object to construct
//    result = self.response_deserializer.__self__()
//    result = Parse(res.content, result)
//    return result
//
}

