<?php

class Admin{

	public $name_category;
	public $description_category;
	public $name_sub_category;
	public $description_sub_category;
	public $name_sub_category_2;
	public $description_sub_category_2;
	public $db;

	public function __construct($db){
    	
    	$this->db = $db;

  	}

  	public function register($name_category,$description_category,$name_sub_category,$description_sub_category,$name_sub_category_2,$description_sub_category_2,$category_parent,$sub_category_parent) {

  		$connexion_db = $this->db->connectDb();
  		
  		if(!empty($name_category AND $description_category)){

  			$add_category = ("INSERT into categories (name_category,description_category) VALUES (:name_category,:description_category)");
  			$execution_insert_category = $connexion_db->prepare($add_category);
  			$execution_insert_category->bindParam(':name_category',$name_category,PDO::PARAM_STR);
  			$execution_insert_category->bindParam(':description_category',$description_category,PDO::PARAM_STR);
  			$execution_insert_category->execute();

  		}

  		
  		if(!empty($name_sub_category AND $description_sub_category)){

  			$add_sub_category = ("INSERT into sub_categories (name_sub_category,description_sub_category) VALUES (:name_sub_category,:description_sub_category)");
  			$execution_insert_sub_category = $connexion_db->prepare($add_sub_category);
  			$execution_insert_sub_category->bindParam(':name_sub_category',$name_sub_category,PDO::PARAM_STR);
  			$execution_insert_sub_category->bindParam(':description_sub_category',$description_sub_category,PDO::PARAM_STR);
  			$execution_insert_sub_category->execute();

  		}

  		if(!empty($name_sub_category_2 AND $description_sub_category_2 AND $category_parent AND $sub_category_parent)){

			$get_category_id = $connexion_db->prepare("SELECT id_category FROM categories WHERE name_category = '$category_parent' ");
            $get_category_id->execute();
            $category_id = $get_category_id->fetch(PDO::FETCH_ASSOC);
            $id_cat = intval($category_id['id_category']);

            $get_sub_category_id = $connexion_db->prepare("SELECT id_sub_category FROM sub_categories WHERE name_sub_category = '$sub_category_parent' ");
            $get_sub_category_id->execute();
            $sub_category_id = $get_sub_category_id->fetch(PDO::FETCH_ASSOC); 			
  			$id_sub_cat = intval($sub_category_id['id_sub_category']);

  			$add_sub_category_2 = 
  			("INSERT into sub_categories_2 (id_category, id_sub_category, name_sub_category_2,description_sub_category_2) VALUES (:id_category,:id_sub_category,:name_sub_category,:description_sub_category)");
  			$execution_insert_sub_category_2 = $connexion_db->prepare($add_sub_category_2);
  			$execution_insert_sub_category_2->bindParam(':id_category',$id_cat,PDO::PARAM_INT);
  			$execution_insert_sub_category_2->bindParam(':id_sub_category',$id_sub_cat,PDO::PARAM_INT);
  			$execution_insert_sub_category_2->bindParam(':name_sub_category',$name_sub_category_2,PDO::PARAM_STR);
  			$execution_insert_sub_category_2->bindParam(':description_sub_category',$description_sub_category_2,PDO::PARAM_STR);
  			$execution_insert_sub_category_2->execute();

  			

  		}



  	}

  	public function update(){

  		$connexion_db = $this->db->connectDb();

  		
  		
  	}
}


?>