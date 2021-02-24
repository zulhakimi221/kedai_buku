<?php

//get all products
function getAllProducts($db)
    {
    $sql = 'Select p.title_book, p.author, p.description,  p.price, c.title_book as category from products p ';
    $sql .='Inner Join categories c on p.category_id = c.id';
    $stmt = $db->prepare ($sql);
    $stmt ->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
//get product by id
function getProduct($db, $productId)
    {
    $sql = 'Select p.title_book, p.author, p.description, p.price, c.name as category from products p ';
    $sql .= 'Inner Join categories c on p.category_id = c.id ';
    $sql .= 'Where p.id = :id'; 
    $stmt = $db->prepare ($sql);
    $id = (int) $productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
function createProduct($db, $form_data) 
    {
    $sql = 'Insert into products (title_book, author, description, price, category_id, published_date) ';
    $sql .= 'values (:title_book, :author, :description, :price, :category_id, :published_date)';
    $stmt = $db->prepare ($sql);
    $stmt->bindParam(':title_book', $form_data['title_book']);
    $stmt->bindParam(':author', $form_data['author']);
    $stmt->bindParam(':description', $form_data['description']);
    $stmt->bindParam(':price', floatval($form_data['price']));
    $stmt->bindParam(':category_id', intval($form_data['category_id']));
    $stmt->bindParam(':published_date', $form_data['published_date']);
    $stmt->execute();
    return $db->lastInsertID();//insert last number.. continue
    }

//delete product by id
function deleteProduct($db,$productId) 
    {
    $sql = ' Delete from products where id = :id';
    $stmt = $db->prepare($sql);
    $id = (int)$productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    
//update product by id
function updateProduct($db,$form_dat,$productId,$date) 
    {
    $sql = 'UPDATE products SET title_book = :title_book , author = :author, description = :description , price = :price , category_id = :category_id , modified = :modified ';
    $sql .=' WHERE id = :id';
    
    $stmt = $db->prepare ($sql);
    $id = (int)$productId;
    $mod = $date;
    
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title_book', $form_dat['title_book']);
        $stmt->bindParam(':author', $form_dat['author']);
        $stmt->bindParam(':description', $form_dat['description']);
        $stmt->bindParam(':price', floatval($form_dat['price']));
        $stmt->bindParam(':category_id', intval($form_dat['category_id']));
        $stmt->bindParam(':modified', $mod , PDO::PARAM_STR);
        $stmt->execute();
      
        $sql1 = 'Select p.title_book, p.author, p.description, p.price, c.name as category from products as p ';
        $sql1 .= 'Inner Join categories c on p.category_id = c.id ';
        $sql1 .= 'Where p.id = :id'; 
        $stmt1 = $db->prepare ($sql1);
        $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }
    
?>
    