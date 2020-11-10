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

        $check_categories = $connexion_db->prepare("SELECT * FROM categories WHERE name_category = '$name_category' ");
        $check_categories->execute();
        $checked_categories = $check_categories->fetchAll(PDO::FETCH_ASSOC);

        if(empty($checked_categories[0])){

          $add_category = ("INSERT into categories (name_category,description_category) VALUES (:name_category,:description_category)");
          $execution_insert_category = $connexion_db->prepare($add_category);
          $execution_insert_category->bindParam(':name_category',$name_category,PDO::PARAM_STR);
          $execution_insert_category->bindParam(':description_category',$description_category,PDO::PARAM_STR);
          $execution_insert_category->execute();

          header('Location:admin.php#admin');
          exit;

        }else{echo "<span>Cette catégorie existe déjà</span>";}


  		}

  		
  		if(!empty($name_sub_category AND $description_sub_category)){

        $check_sub_categories = $connexion_db->prepare("SELECT * FROM sub_categories WHERE name_sub_category = '$name_sub_category'");
        $check_sub_categories->execute();
        $checked_sub_categories = $check_sub_categories->fetchAll(PDO::FETCH_ASSOC);

        if(empty($checked_sub_categories[0])){

    			$add_sub_category = ("INSERT into sub_categories (name_sub_category,description_sub_category) VALUES (:name_sub_category,:description_sub_category)");
    			$execution_insert_sub_category = $connexion_db->prepare($add_sub_category);
    			$execution_insert_sub_category->bindParam(':name_sub_category',$name_sub_category,PDO::PARAM_STR);
    			$execution_insert_sub_category->bindParam(':description_sub_category',$description_sub_category,PDO::PARAM_STR);
    			$execution_insert_sub_category->execute();

          header('Location:admin.php#admin');
          exit;

        }else{echo "<span>Cette sous catégorie existe déjà</span>";}

  		}

  		if(!empty($name_sub_category_2 AND $description_sub_category_2 AND $category_parent AND $sub_category_parent)){

        $id_category = intval($category_parent);
        $id_sub_category = intval($sub_category_parent);

        $check_sub_categories_2 = $connexion_db->prepare("SELECT * FROM sub_categories_2 WHERE name_sub_category_2 = '$name_sub_category_2'AND id_category = $id_category AND id_sub_category = $id_sub_category");
        $check_sub_categories_2->execute();
        $checked_sub_categories_2 = $check_sub_categories_2->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($checked_sub_categories_2[0])){

          $add_sub_category_2 = 
          ("INSERT into sub_categories_2 (id_category, id_sub_category, name_sub_category_2,description_sub_category_2) VALUES (:id_category,:id_sub_category,:name_sub_category,:description_sub_category)");
          $execution_insert_sub_category_2 = $connexion_db->prepare($add_sub_category_2);
          $execution_insert_sub_category_2->bindParam(':id_category',$id_category,PDO::PARAM_INT);
          $execution_insert_sub_category_2->bindParam(':id_sub_category',$id_sub_category,PDO::PARAM_INT);
          $execution_insert_sub_category_2->bindParam(':name_sub_category',$name_sub_category_2,PDO::PARAM_STR);
          $execution_insert_sub_category_2->bindParam(':description_sub_category',$description_sub_category_2,PDO::PARAM_STR);
          $execution_insert_sub_category_2->execute();

          header('Location:admin.php#admin');
          exit;

        }else{echo "<span>Cette sous catégorie 2 existe déjà</span>";}

  			

  		}



  	}

  	public function update(){

  		$connexion_db = $this->db->connectDb();

  		
  		
  	}
}


?>