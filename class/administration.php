<?php

class Admin
{
    public $id_category;
    public $id_sub_category;
    public $id_sub_category_2;
    public $name_category;
    public $description_category;
    public $name_sub_category;
    public $description_sub_category;
    public $name_sub_category_2;
    public $description_sub_category_2;
    public $db;

    public function __construct($db)
    {

        $this->db = $db;

    }

    public function register($name_category, $description_category, $name_sub_category, $description_sub_category, $name_sub_category_2, $description_sub_category_2, $category_parent, $sub_category_parent)
    {

        $connexion_db = $this->db->connectDb();

        if (!empty($name_category and $description_category)) {

            $check_categories = $connexion_db->prepare("SELECT * FROM categories WHERE name_category = '$name_category' ");
            $check_categories->execute();
            $checked_categories = $check_categories->fetchAll(PDO::FETCH_ASSOC);

            if (empty($checked_categories[0])) {

                $add_category = ("INSERT into categories (name_category,description_category) VALUES (:name_category,:description_category)");
                $execution_insert_category = $connexion_db->prepare($add_category);
                $execution_insert_category->bindParam(':name_category', $name_category, PDO::PARAM_STR);
                $execution_insert_category->bindParam(':description_category', $description_category, PDO::PARAM_STR);
                $execution_insert_category->execute();

                header('Location:admin.php#admin');
                exit;

            } else {
                echo "<span>Cette catégorie existe déjà</span>";
            }


        }


        if (!empty($name_sub_category and $description_sub_category)) {

            $check_sub_categories = $connexion_db->prepare("SELECT * FROM sub_categories WHERE name_sub_category = '$name_sub_category'");
            $check_sub_categories->execute();
            $checked_sub_categories = $check_sub_categories->fetchAll(PDO::FETCH_ASSOC);

            if (empty($checked_sub_categories[0])) {

                $add_sub_category = ("INSERT into sub_categories (name_sub_category,description_sub_category) VALUES (:name_sub_category,:description_sub_category)");
                $execution_insert_sub_category = $connexion_db->prepare($add_sub_category);
                $execution_insert_sub_category->bindParam(':name_sub_category', $name_sub_category, PDO::PARAM_STR);
                $execution_insert_sub_category->bindParam(':description_sub_category', $description_sub_category, PDO::PARAM_STR);
                $execution_insert_sub_category->execute();

                header('Location:admin.php#admin');
                exit;

            } else {
                echo "<span>Cette sous catégorie existe déjà</span>";
            }

        }

        if (!empty($name_sub_category_2 and $description_sub_category_2 and $category_parent and $sub_category_parent)) {

            $id_category = intval($category_parent);
            $id_sub_category = intval($sub_category_parent);

            $check_sub_categories_2 = $connexion_db->prepare("SELECT * FROM sub_categories_2 WHERE name_sub_category_2 = '$name_sub_category_2'AND id_category = $id_category AND id_sub_category = $id_sub_category");
            $check_sub_categories_2->execute();
            $checked_sub_categories_2 = $check_sub_categories_2->fetchAll(PDO::FETCH_ASSOC);

            if (empty($checked_sub_categories_2[0])) {

                $add_sub_category_2 =
                    ("INSERT into sub_categories_2 (id_category, id_sub_category, name_sub_category_2,description_sub_category_2) VALUES (:id_category,:id_sub_category,:name_sub_category,:description_sub_category)");
                $execution_insert_sub_category_2 = $connexion_db->prepare($add_sub_category_2);
                $execution_insert_sub_category_2->bindParam(':id_category', $id_category, PDO::PARAM_INT);
                $execution_insert_sub_category_2->bindParam(':id_sub_category', $id_sub_category, PDO::PARAM_INT);
                $execution_insert_sub_category_2->bindParam(':name_sub_category', $name_sub_category_2, PDO::PARAM_STR);
                $execution_insert_sub_category_2->bindParam(':description_sub_category', $description_sub_category_2, PDO::PARAM_STR);
                $execution_insert_sub_category_2->execute();

                header('Location:admin.php#admin');
                exit;

            } else {
                echo "<span>Cette sous catégorie 2 existe déjà</span>";
            }

        }

    }

    public function updateCategory($id_category, $name_category, $description_category)
    {

        $connexion_db = $this->db->connectDb();

        if (!empty($name_category)) {

            $new_category_name = "UPDATE categories SET name_category = :name_category WHERE id_category = $id_category";
            $update_category_name = $connexion_db->prepare($new_category_name);
            $update_category_name->bindParam(':name_category', $name_category, PDO::PARAM_STR);
            $update_category_name->execute();

        }

        if (!empty($description_category)) {

            $new_category_description = "UPDATE categories SET description_category = :description_category WHERE id_category = $id_category";
            $update_category_description = $connexion_db->prepare($new_category_description);
            $update_category_description->bindParam(':description_category', $description_category, PDO::PARAM_STR);
            $update_category_description->execute();

        }

        header('Location:admin.php#categories');
        exit;

    }

    public function updateSubCategory($id_sub_category, $name_sub_category, $description_sub_category)
    {

        $connexion_db = $this->db->connectDb();

        if (!empty($name_sub_category)) {

            $new_sub_category_name = "UPDATE sub_categories SET name_sub_category = :name_sub_category WHERE id_sub_category = $id_sub_category";
            $update_sub_category_name = $connexion_db->prepare($new_sub_category_name);
            $update_sub_category_name->bindParam(':name_sub_category', $name_sub_category, PDO::PARAM_STR);
            $update_sub_category_name->execute();

        }

        if (!empty($description_sub_category)) {

            $new_sub_category_description = "UPDATE sub_categories SET description_sub_category = :description_sub_category WHERE id_sub_category = $id_sub_category";
            $update_sub_category_description = $connexion_db->prepare($new_sub_category_description);
            $update_sub_category_description->bindParam(':description_sub_category', $description_sub_category, PDO::PARAM_STR);
            $update_sub_category_description->execute();

        }

        header('Location:admin.php#sub_categories');
        exit;

    }

    public function updateSubCategory_2($id_sub_category_2, $name_sub_category_2, $description_sub_category_2, $category_parent, $sub_category_parent)
    {

        $connexion_db = $this->db->connectDb();

        if (!empty($name_sub_category_2)) {

            $new_sub_category_2_name = "UPDATE sub_categories_2 SET name_sub_category_2 = :name_sub_category_2 WHERE id_sub_category_2 = $id_sub_category_2";
            $update_sub_category_2_name = $connexion_db->prepare($new_sub_category_2_name);
            $update_sub_category_2_name->bindParam(':name_sub_category_2', $name_sub_category_2, PDO::PARAM_STR);
            $update_sub_category_2_name->execute();

        }

        if (!empty($description_sub_category_2)) {

            $new_sub_category_2_description = "UPDATE sub_categories_2 SET description_sub_category_2 = :description_sub_category_2 WHERE id_sub_category_2 = $id_sub_category_2";
            $update_sub_category_2_description = $connexion_db->prepare($new_sub_category_2_description);
            $update_sub_category_2_description->bindParam(':description_sub_category_2', $description_sub_category_2, PDO::PARAM_STR);
            $update_sub_category_2_description->execute();

        }

        if (!empty($category_parent)) {

            $id_category = intval($category_parent);

            $new_category_parent = "UPDATE sub_categories_2 SET id_category = :id_category WHERE id_sub_category_2 = $id_sub_category_2";
            $update_category_parent = $connexion_db->prepare($new_category_parent);
            $update_category_parent->bindParam(':id_category', $id_category, PDO::PARAM_INT);
            $update_category_parent->execute();

        }

        if (!empty($sub_category_parent)) {

            $id_sub_category = intval($sub_category_parent);

            $new_sub_category_parent = "UPDATE sub_categories_2 SET id_sub_category = :id_sub_category WHERE id_sub_category_2 = $id_sub_category_2";
            $update_sub_category_parent = $connexion_db->prepare($new_sub_category_parent);
            $update_sub_category_parent->bindParam(':id_sub_category', $id_sub_category, PDO::PARAM_INT);
            $update_sub_category_parent->execute();

        }

        header('Location:admin.php#sub_categories_2');
        exit;

    }

    public function deleteCategory($id_category)
    {

        $connexion_db = $this->db->connectDb();

        //SUPPRESSION DANS CATEGORIES DE LA CATEGORIE SELECTIONNEE
        $delete_category = $connexion_db->prepare("DELETE FROM categories WHERE id_category = $id_category");
        $delete_category->execute();

        header('Location:admin.php#categories');
        exit;


    }

    public function deleteSubCategory($id_sub_category)
    {

        $connexion_db = $this->db->connectDb();

        $delete_sub_category = $connexion_db->prepare("DELETE FROM sub_categories WHERE id_sub_category = $id_sub_category");
        $delete_sub_category->execute();

        header('Location:admin.php#sub_categories');
        exit;


    }

    public function deleteSubCategory2($id_sub_category_2)
    {

        $connexion_db = $this->db->connectDb();

        if (!empty($id_sub_category_2)) {

            $check_id_sub_category_2 = $connexion_db->prepare("SELECT id_sub_category_2 FROM products WHERE id_sub_category_2 = $id_sub_category_2 ");
            $check_id_sub_category_2->execute();
            $checked_id_sub_category_2 = $check_id_sub_category_2->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($checked_id_sub_category_2[0])) {

                $get_new_sub_category_2 = $connexion_db->prepare("SELECT id_sub_category_2 FROM sub_categories_2 WHERE id_sub_category_2 != $id_sub_category_2");
                $get_new_sub_category_2->execute();
                $new_sub_category_2 = $get_new_sub_category_2->fetchAll(PDO::FETCH_ASSOC);

                $new_id_sub_category_2 = intval($new_sub_category_2[0]);
                var_dump($new_id_sub_category_2);
                $new_product_sub_category_2 = " UPDATE products SET id_sub_category_2 = :new_id_sub_category_2 WHERE id_sub_category_2 = $id_sub_category_2 ";
                $update_product_sub_category_2 = $connexion_db->prepare($new_product_sub_category_2);
                $update_product_sub_category_2->bindParam(':new_id_sub_category_2', $new_id_sub_category_2, PDO::PARAM_INT);
                $update_product_sub_category_2->execute();

            }

            $delete_sub_category = $connexion_db->prepare("DELETE FROM sub_categories_2 WHERE id_sub_category_2 = $id_sub_category_2");
            $delete_sub_category->execute();

            header('Location:admin.php#sub_category_2');
            exit;
        }

    }

    public function getProductsByCategory($id_category)
    {
        $connexion_db = $this->db->connectDb();

        $get_products_per_category = $connexion_db->prepare("SELECT DISTINCT

            categories.id_category,
            categories.name_category,
            categories.description_category,

            sub_categories_2.id_category,
            sub_categories_2.id_sub_category_2,

            products.id_product,
            products.id_sub_category_2,
            products.product_name,
            products.picture,
            products.price,

            product_details.id_product,
            product_details.color

            FROM 

            products, categories, sub_categories_2, product_details

            WHERE 

            products.id_sub_category_2 = sub_categories_2.id_sub_category_2
            AND sub_categories_2.id_category = ?
            AND categories.id_category = sub_categories_2.id_category
            AND products.id_product = product_details.id_product

            ");

        $get_products_per_category->execute([$id_category]);
        $all_products = $get_products_per_category->fetchAll(PDO::FETCH_ASSOC);

        return $all_products;
    }

    public function getProductsBySubCategory($id_category, $id_sub_category){

        $connexion_db = $this->db->connectDb();

        $get_products_per_sub_category = $connexion_db->prepare("SELECT DISTINCT

            categories.id_category,
            categories.name_category,

            sub_categories.id_sub_category,
            sub_categories.name_sub_category,
            sub_categories.description_sub_category,

            sub_categories_2.id_sub_category_2,
            sub_categories_2.id_category,
            sub_categories_2.id_sub_category,

            
            products.id_product,
            products.id_sub_category_2,
            products.product_name,
            products.picture,
            products.price,

            product_details.id_product,
            product_details.color

            FROM 

            products, categories, sub_categories, sub_categories_2, product_details

            WHERE 

            products.id_sub_category_2 = sub_categories_2.id_sub_category_2
            AND sub_categories_2.id_category =  ?
            AND sub_categories_2.id_sub_category =  ?
            AND categories.id_category = sub_categories_2.id_category
            AND sub_categories.id_sub_category = sub_categories_2.id_sub_category
            AND products.id_product = product_details.id_product

            ");

        $get_products_per_sub_category->execute([$id_category,$id_sub_category]);
        $all_products = $get_products_per_sub_category->fetchAll(PDO::FETCH_ASSOC);

        return $all_products;

    }

    public function getProductsBySubCategory2($id_category, $id_sub_category, $id_sub_category_2)
    {
        $connexion_db = $this->db->connectDb();

        $get_products_per_sub_category_2 = $connexion_db->prepare("SELECT DISTINCT

            categories.id_category,
            categories.name_category,

            sub_categories.id_sub_category,
            sub_categories.name_sub_category,

            sub_categories_2.id_sub_category_2,
            sub_categories_2.id_category,
            sub_categories_2.id_sub_category,
            sub_categories_2.name_sub_category_2,
            sub_categories_2.description_sub_category_2,

            products.id_product,
            products.id_sub_category_2,
            products.product_name,
            products.picture,
            products.price,

            product_details.id_product,
            product_details.color

            FROM 

            products, categories, sub_categories, sub_categories_2, product_details

            WHERE 

            products.id_sub_category_2 = sub_categories_2.id_sub_category_2
            AND sub_categories_2.id_category =  ?
            AND sub_categories_2.id_sub_category =  ?
            AND sub_categories_2.id_sub_category_2 =  ?
            AND categories.id_category = sub_categories_2.id_category
            AND sub_categories.id_sub_category = sub_categories_2.id_sub_category
            AND products.id_product = product_details.id_product

            ");

        $get_products_per_sub_category_2->execute([$id_category,$id_sub_category,$id_sub_category_2]);
        $all_products = $get_products_per_sub_category_2->fetchAll(PDO::FETCH_ASSOC);

        return $all_products;
    }


}


?>