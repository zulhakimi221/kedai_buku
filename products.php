<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include productsProc.php file
include __DIR__ . '/../Controllers/productsProc.php';

//read table products
$app->get('/products', function (Request $request, Response $response, array $arg){
  return $this->response->withJson(array('data' => 'success'), 200);
});

//request table products by condition
$app->get('/products/[{id}]', function ($request, $response, $args){
    
    $productId = $args['id'];
   if (!is_numeric($productId)) {
      return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
   }
  $data = getProduct($this->db, $productId);
  if (empty($data)) {
    return $this->response->withJson(array('error' => 'no data'), 404);
 }
   return $this->response->withJson(array('data' => $data), 200);
});

$app->post('/products/add', function ($request, $response, $args) {
  $form_data = $request->getParsedBody();
  $data = createProduct($this->db, $form_data);
  if ($data <= 0) {
    return $this->response->withJson(array('error' => 'add data fail'), 500);
  }
  return $this->response->withJson(array('add data' => 'success'), 201);
  }
);

//delete row
$app->delete('/products/del/[{id}]', function ($request, $response, $args){
    
  $productId = $args['id'];
 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
$data = deleteProduct($this->db,$productId);
if (empty($data)) {
 return $this->response->withJson(array($productId=> 'is successfully deleted'), 202);};
});

//put table products
$app->put('/products/put/[{id}]', function ($request,  $response,  $args){
  $productId = $args['id'];
  $date = date("Y-m-j h:i:s");
  
 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
  $form_dat=$request->getParsedBody();
  
$data=updateProduct($this->db,$form_dat,$productId,$date);

return $this->response->withJson(array('data' => $data), 200);
});
