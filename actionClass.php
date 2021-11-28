<?php
class USER
{
   private $db;
   function __construct($DB_con)
   {
   $this->db = $DB_con;
   }
   public function register($fullname,$email,$username,$password,$level)
   {
      try
         {
            $new_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users(ID,fullname,username,email,password,level,create_date) 
            VALUES(NUll,:fullname,:username, :email, :new_password,:level,current_timestamp)");
            $stmt->bindparam(":fullname", $fullname);
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":new_password", $new_password);   
            $stmt->bindparam(":level", $level);       
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }
   public function login($username,$password)
   {
      try
      {
         $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username LIMIT 1");
         $stmt->execute(array(':username'=>$username));
         $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
         if($stmt->rowCount() > 0)
         {
            if(password_verify($password, $userRow['password']))
            {
               if($userRow['level'] == 2)
               {
                  $_SESSION['user_session'] = $userRow['fullname'];
                  return true;
               }else{
                  echo "Tài khoản của bạn không có quyền truy cập vào trang Admin";
               }
            }
            else
            {
               echo "Mật khẩu không chính xác. Hãy nhập lại";
               return false;
            }
         }else{
            echo "Tài khoản đăng nhập không chính xác. Vui lòng nhập lại";
         }
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
      }
   }
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
   public function redirect($url)
   {
       header("Location: $url");
   }
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
   public function getUsers($current_page,$pageTotal,$limit,$start)
   {
      try
       {
         $stmt = $this->db->prepare("SELECT * FROM users ORDER BY ID DESC limit {$limit},{$start}");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $current_page = $current_page;
            $pageTotal = $pageTotal;
            if ($stmt->rowCount() > 0) {
               if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
               echo "<table>";
               foreach ($result as $item) {
                  echo "<tr>";
                     echo "<td class='fullname'>".$item['fullname']."</td>";
                     echo "<td class='email'>".$item['email']."</td>";
                     echo "<td class='username'>".$item['username']."</td>";
                     echo "<td class='create_date'>".date('d/m/Y',strtotime($item['create_date']))."</td>";
                     echo "<td class='level'>" ;
                     if($item['level'] == 2)
                     {
                         echo "Admin";
                     }
                     else{
                        echo " Thành viên";
                     }
                     "</td>";
                     echo " <td><button class='btn btn-success btn-xs' id='btnViewUser'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickEditUser btn btn-warning btn-xs' data-title='Edit' data-toggle='modal' data-target='#editUser'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickDeleteUser btn btn-danger btn-xs' >
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                     </svg>
                   </button></td>";
                  echo "</tr>";
               }
            }

               // Close the table
               echo "</table>";
                  echo "<nav aria-label='Page navigation example'>";
                  echo "<ul class='pagination justify-content-center'>";
                     if ($current_page > 1)
                     {
                        echo "<li class='page-item'><a id='".($current_page - 1)."' class='page-link' href='listUsers.php?page=".($current_page - 1)."'>«</a></li>";
                     }
                     for ($i = 1; $i <= $pageTotal; $i++)
                     {
                        echo "<li class='page-item";
                        if($current_page == $i)
                        {
                           echo ' disabled';
                        }
                        echo "'><a id='$i' class='page-link' href='listUsers.php?page=$i'> $i </a>";
                        echo"</li>";
                     }
                        
                        
                     if ($current_page < $pageTotal)
                     {
                        echo "<li class='page-item'><a id='".($current_page + 1)."' class='page-link' href='listUsers.php?page=".($current_page + 1)."'>»</a></li>";
                     }
                        
                  echo "</ul>";
                  echo "</nav>";
            }
            else {
               echo "0 sản phẩm";
            }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
   }
   public function countUser()
   {
      try{
         $stmt = $this->db->prepare("SELECT count(*) AS total FROM users");
         $stmt->execute();
         $result = $stmt->fetch();

         return $result['total'];
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }   
   }
   public function showUser($id)
   {
      try{
         $stmt= $this->db->prepare("SELECT * FROM users WHERE ID = :id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
         $result = $stmt->fetch();
         echo "<form id='updateFormCoupon'>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Họ tên</label>";
            echo  "<input type='text' id='fullnameShow' placeholder='Mã giảm giá' class='form-control' value='".$result['fullname']."' />";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Email</label>";
            echo  "<input type='text' id='emailShow' class='form-control' value='".$result['email']."'/>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Tên đăng nhập</label>";
            echo  "<input type='text' id='usernameShow' class='form-control' value='".$result['username']."' disabled>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Loại tài khoản</label>";
            echo" <select type='number' id='levelShow' class='form-select'>";
                  echo "<option value='".$result['level']."'>";
                  if($result['level']==2){
                     echo "Admin";
                  }else{
                     echo "Thành viên";
                  }
                  echo "</option>";
                  echo "<option value='2'>Admin</option>";
                  echo "<option value='1'>Thành viên</option>";
            echo "</select>";
         echo "</div>";
         echo "<div class='modal-footer'>";
            echo "<button type='button' id='".$result['ID']."'  class='clickUpdateUser btn btn-warning btn-lg' style='width: 100%;'>Cập nhật</button>";
         echo "</div>";
         echo "</form>";
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function updateUser($id,$fullname,$email,$level)
   {
      try
         {
            $stmt = $this->db->prepare("UPDATE users 
            SET `fullname` = :fullname , 
               `level` = :level,
               `email` = :email
            WHERE ID = :id");
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":fullname", $fullname);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":level", $level);        
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }
   public function deleteUser($id)
   {
      try{
         $stmt= $this->db->prepare("DELETE from users WHERE ID=:id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
}
class CATEGORY{
   private $db;
   function __construct($DB_con)
   {
   $this->db = $DB_con;
   }
   public function getCategories($current_page,$pageTotal,$limit,$start)
   {
      try
       {
         $stmt = $this->db->prepare("SELECT * FROM type_product ORDER BY ID DESC limit {$limit},{$start}");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $current_page = $current_page;
            $pageTotal = $pageTotal;
            if ($stmt->rowCount() > 0) {
               if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
               echo "<table>";
               foreach ($result as $item) {
                  echo "<tr>";
                     echo "<td class='name'>".$item['name']."</td>";
                     echo "<td class='create_date'>".date('d/m/Y',strtotime($item['create_date']))."</td>";
                     echo " <td><button class='btn btn-success btn-xs' id='btnViewCategory'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickEditCategory btn btn-warning btn-xs' data-title='Edit' data-toggle='modal' data-target='#editCategory'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickDeleteCategory btn btn-danger btn-xs' >
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                     </svg>
                   </button></td>";
                  echo "</tr>";
               }
            }

               // Close the table
               echo "</table>";
                  echo "<nav aria-label='Page navigation example'>";
                  echo "<ul class='pagination justify-content-center'>";
                     if ($current_page > 1)
                     {
                        echo "<li class='page-item'><a id='".($current_page - 1)."' class='page-link' href='listCategories.php?page=".($current_page - 1)."'>«</a></li>";
                     }
                     for ($i = 1; $i <= $pageTotal; $i++)
                     {
                        echo "<li class='page-item";
                        if($current_page == $i)
                        {
                           echo ' disabled';
                        }
                        echo "'><a id='$i' class='page-link' href='listCategories.php?page=$i'> $i </a>";
                        echo"</li>";
                     }
                        
                        
                     if ($current_page < $pageTotal)
                     {
                        echo "<li class='page-item'><a id='".($current_page + 1)."' class='page-link' href='listCategories.php?page=".($current_page + 1)."'>»</a></li>";
                     }
                        
                  echo "</ul>";
                  echo "</nav>";
            }
            else {
               echo "0 sản phẩm";
            }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
   }
   public function countCategory()
   {
      try{
         $stmt = $this->db->prepare("SELECT count(*) AS total FROM type_product");
         $stmt->execute();
         $result = $stmt->fetch();

         return $result['total'];
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }   
   }
   public function addCategory($name)
   {
      try
         {
            $stmt = $this->db->prepare("INSERT INTO `type_product` (`ID`, `name`,`create_date`) 
            VALUES (NULL, :name , current_timestamp)");
            $stmt->bindparam(":name", $name);    
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }
   public function deleteCategory($id)
   {
      try{
         $stmt= $this->db->prepare("DELETE from type_product WHERE id=:id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function showCategory($id)
   {
      try{
         $stmt= $this->db->prepare("SELECT * FROM type_product WHERE ID = :id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
         $result = $stmt->fetch();
         echo "<form id='updateFormCategories'>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Tên loại sản phẩm</label>";
            echo  "<input type='text' id='nameShow' placeholder='Mã giảm giá' class='form-control' value='".$result['name']."' />";
         echo "</div>";
         echo "<div class='modal-footer'>";
            echo "<button type='button' id='".$result['ID']."'  class='clickUpdateCategory btn btn-warning btn-lg' style='width: 100%;'>Cập nhật</button>";
         echo "</div>";
         echo "</form>";
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function updateCategory($id,$name)
   {
      try
         {
            $stmt = $this->db->prepare("UPDATE type_product 
            SET `name` = :name
            WHERE `ID` = :id");
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":name", $name);      
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }

}
class PRODUCT
{
   private $db;
 
   function __construct($DB_con)
   {
      $this->db = $DB_con;
   }
   public function addProduct($product_name,$type_id,$old_price,$new_price, $quantity,$status,$show)
   {
      try
         {
            $stmt = $this->db->prepare("INSERT INTO `products` (`ID`, `product_name`,`type_id`, `old_price`, `new_price`, `quantity`, `create_date`, `status`, `show`) VALUES
            (NULL, :product_name,:type_id, :old_price, :new_price, :quantity, current_timestamp, :status_product, :show_product)");
            $stmt->bindparam(":product_name", $product_name);
            $stmt->bindparam(":type_id", $type_id);
            $stmt->bindparam(":old_price", $old_price);
            $stmt->bindparam(":new_price", $new_price);
            $stmt->bindparam(":quantity", $quantity);         
            $stmt->bindparam(":status_product", $status);     
            $stmt->bindparam(":show_product", $show);      
            $stmt->execute(); 
         }
       catch(PDOException $e)
       {
           echo $e->getMessage();
           exit;
       }    
   }
   public function deleteProduct($id)
   {
      try{
         $stmt= $this->db->prepare("DELETE from products WHERE id=:id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function showProduct($id)
   {
      try{
         $stmt= $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show, type_product.name AS name_type
         FROM products
         INNER JOIN type_product ON products.type_id=type_product.ID WHERE products.ID = :id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
         $result = $stmt->fetch();
         echo "<form id='updateForm'>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Tên sản phẩm</label>";
            echo  "<input type='text' id='product_nameShow' placeholder='Tên sản phẩm' class='form-control' value='".$result['product_name']."' />";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Tên thể loại</label>";
            echo" <select type='number' id='type_idShow' class='form-select' disabled >";
                  echo "<option value='".$result['type_id']."'>";
                  echo $result['name_type'];
                  echo "</option>";
           echo "</select>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Giá cũ</label>";
            echo  "<input type='number' id='old_priceShow' placeholder='Tên sản phẩm' class='form-control' value='".$result['old_price']."' />";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Giá mới</label>";
            echo  "<input type='number' id='new_priceShow' placeholder='Tên sản phẩm' class='form-control' value='".$result['new_price']."' />";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Số lượng</label>";
            echo  "<input type='number' id='quantityShow' placeholder='Tên sản phẩm' class='form-control' value='".$result['quantity']."' />";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Tình trạng</label>";
            echo" <select type='number' id='statusShow' class='form-select' aria-label='Default select example' >";
                  echo "<option value='".$result['status']."'>";
                  if($result['status']==0){
                     echo "Default";
                  }elseif($result['status']==0){
                     echo "New";
                  }else{
                     echo "Hot";
                  }
                  echo "</option>";
                  echo "<option value='0'>Mặc định</option>";
                  echo "<option value='1'>New</option>";
                  echo "<option value='2'>Hot</option>";
           echo "</select>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Tình trạng</label>";
            echo" <select type='number' id='showShow' class='form-select' aria-label='Default select example' >";
                  echo "<option value='".$result['show']."'>";
                  if($result['show']==0){
                     echo "Hiện";
                  }else{
                     echo "Ẩn";
                  }
                  echo "</option>";
                  echo "<option value='0'>Hiện</option>";
                  echo "<option value='1'>Ẩn</option>";
           echo "</select>";
         echo "</div>";
         echo "<div class='modal-footer'>";
            echo "<button type='button' id='".$result['ID']."'  class='clickUpdate btn btn-warning btn-lg' style='width: 100%;'>Cập nhật</button>";
         echo "</div>";
         echo "</form>";
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function updateProduct($id,$product_name,$type_id,$old_price,$new_price, $quantity,$status,$show)
   {
      try
         {
            $stmt = $this->db->prepare("UPDATE products 
            SET product_name = :product_name, 
               `type_id` = :type_id, 
               old_price = :old_price, 
               new_price = :new_price, 
               quantity = :quantity,
               `status` = :status_product,
               `show` = :show_product
               WHERE ID = :id");
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":product_name", $product_name);
            $stmt->bindparam(":type_id", $type_id);
            $stmt->bindparam(":old_price", $old_price);
            $stmt->bindparam(":new_price", $new_price);
            $stmt->bindparam(":quantity", $quantity);         
            $stmt->bindparam(":status_product", $status);     
            $stmt->bindparam(":show_product", $show);   
            echo ("OK");   
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }
   public function ajaxViewProducts($limit,$start,$current_page,$pageTotal,$showValue,$dateFrom,$dateTo)
   {
      try
       {
            if($showValue == 0 && $dateFrom == null && $dateTo == null){
               $stmt = $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show,products.create_date, type_product.name AS name_type FROM products INNER JOIN type_product ON products.type_id=type_product.ID ORDER BY `ID` DESC limit {$limit},{$start}");
            }elseif($showValue == 1 && $dateFrom == null && $dateTo == null){
               $stmt = $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show,products.create_date, type_product.name AS name_type FROM products INNER JOIN type_product ON products.type_id=type_product.ID ORDER BY `product_name` ASC limit {$limit},{$start}");
            }elseif($showValue == 2 && $dateFrom == null && $dateTo == null){
               $stmt = $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show,products.create_date, type_product.name AS name_type FROM products INNER JOIN type_product ON products.type_id=type_product.ID ORDER BY `new_price` ASC limit {$limit},{$start}");
            }elseif($showValue == 3 && $dateFrom == null && $dateTo == null){
               $stmt = $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show,products.create_date, type_product.name AS name_type FROM products INNER JOIN type_product ON products.type_id=type_product.ID ORDER BY `status` ASC limit {$limit},{$start}");
            }elseif($showValue == 4 && $dateFrom == null && $dateTo == null){
               $stmt = $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show,products.create_date, type_product.name AS name_type FROM products INNER JOIN type_product ON products.type_id=type_product.ID ORDER BY `show` ASC limit {$limit},{$start}");
            }else{
               $stmt = $this->db->prepare("SELECT products.ID,products.product_name,products.type_id,products.old_price,products.new_price,products.quantity,products.status,products.show,products.create_date, type_product.name AS name_type FROM products INNER JOIN type_product ON products.type_id=type_product.ID WHERE products.create_date BETWEEN '{$dateFrom}' AND '{$dateTo}' ORDER BY `ID` DESC");
            }
            $stmt->execute();
            $result = $stmt->fetchAll();
            $current_page = $current_page;
            $pageTotal = $pageTotal;
            if ($stmt->rowCount() > 0) {
               if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
               echo "<table>";
               foreach ($result as $item) {
                  echo "<tr>";
                     echo "<td><input type='checkbox' class='checkthis'" ;
                              if($item['show']== 0)
                              {
                                 echo "checked";
                              }
                           echo "/></td>";
                     echo "<td class='product_name'>".$item['product_name']."</td>";
                     echo "<td class='type_id'>".$item['name_type']."</td>";
                     echo "<td class='old_price'>".number_format($item['old_price'])." VNĐ</td>";
                     echo "<td class='new_price'>".number_format($item['new_price'])." VNĐ</td>";
                     echo "<td class='quantity'>".$item['quantity']." sản phẩm</td>";
                     echo "<td class='status'>" ;
                     if($item['status'] == 0)
                     {
                         echo "Default";
                     }elseif($item['status'] == 0)
                     {
                        echo "New";
                     }
                     else{
                        echo "Hot";
                     }
                     "</td>";
                     echo " <td><button class='btn btn-success btn-xs' id='btnView'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickEdit btn btn-warning btn-xs' data-title='Edit' data-toggle='modal' data-target='#edit'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickDelete btn btn-danger btn-xs' >
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                     </svg>
                   </button></td>";
                  echo "</tr>";
               }
            }

               // Close the table
               echo "</table>";
               if($dateFrom == null && $dateTo == null)
               {
                  echo "<nav aria-label='Page navigation example'>";
                  echo "<ul class='pagination justify-content-center'>";
                     if ($current_page > 1)
                     {
                        echo "<li class='page-item'><a id='".($current_page - 1)."' class='page-link' href='dashboard.php?page=".($current_page - 1)."'>«</a></li>";
                     }
                     for ($i = 1; $i <= $pageTotal; $i++)
                     {
                        echo "<li class='page-item";
                        if($current_page == $i)
                        {
                           echo ' disabled';
                        }
                        echo "'><a id='$i' class='page-link' href='dashboard.php?page=$i'> $i </a>";
                        echo"</li>";
                     }
                        
                        
                     if ($current_page < $pageTotal)
                     {
                        echo "<li class='page-item'><a id='".($current_page + 1)."' class='page-link' href='dashboard.php?page=".($current_page + 1)."'>»</a></li>";
                     }
                        
                  echo "</ul>";
                  echo "</nav>";
               }
            }
            else {
               echo "0 sản phẩm";
            }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
   }
   public function countProduct()
   {
      try{
         $stmt = $this->db->prepare("SELECT count(*) AS total FROM products");
         $stmt->execute();
         $result = $stmt->fetch();

         return $result['total'];
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }   
   }
   public function typeProduct()
   {
      try{
         $stmt = $this->db->prepare("SELECT * FROM type_product");
         $stmt->execute();
         $result = $stmt->fetchAll();
         return $result;
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }   
   }
}
class COUPON
{
   private $db;
 
   function __construct($DB_con)
   {
      $this->db = $DB_con;
   }
   public function getCoupons($current_page,$pageTotal,$limit,$start)
   {
      try
       {
         $stmt = $this->db->prepare("SELECT * FROM coupon ORDER BY ID DESC limit {$limit},{$start}");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $current_page = $current_page;
            $pageTotal = $pageTotal;
            if ($stmt->rowCount() > 0) {
               if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
               echo "<table>";
               foreach ($result as $item) {
                  echo "<tr>";
                     echo "<td class='coupon_code'>".$item['coupon_code']."</td>";
                     echo "<td class='type_coupon'>" ;
                     if($item['type_coupon'] == 0)
                     {
                         echo "Giảm theo %";
                     }
                     else{
                        echo "Giảm tiền";
                     }
                     "</td>";
                     echo "<td class='date_start'>".date('d/m/Y',strtotime($item['date_start']))."</td>";
                     echo "<td class='date_end'>".date('d/m/Y',strtotime($item['date_end']))."</td>";
                     echo "<td class='scale'>" ;
                     if($item['type_coupon'] == 0)
                     {
                         echo $item['scale']." %";
                     }
                     else{
                        echo number_format($item['scale'])." VNĐ";
                     }
                     "</td>";
                     echo " <td><button class='btn btn-success btn-xs' id='btnViewCoupon'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickEditCoupon btn btn-warning btn-xs' data-title='Edit' data-toggle='modal' data-target='#editCoupon'>
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                     </svg>
                     </button></td>";
                     echo "<td><button id='".$item['ID']."' class='clickDeleteCoupon btn btn-danger btn-xs' >
                     <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                     </svg>
                   </button></td>";
                  echo "</tr>";
               }
            }

               // Close the table
               echo "</table>";
                  echo "<nav aria-label='Page navigation example'>";
                  echo "<ul class='pagination justify-content-center'>";
                     if ($current_page > 1)
                     {
                        echo "<li class='page-item'><a id='".($current_page - 1)."' class='page-link' href='listCoupon.php?page=".($current_page - 1)."'>«</a></li>";
                     }
                     for ($i = 1; $i <= $pageTotal; $i++)
                     {
                        echo "<li class='page-item";
                        if($current_page == $i)
                        {
                           echo ' disabled';
                        }
                        echo "'><a id='$i' class='page-link' href='listCoupon.php?page=$i'> $i </a>";
                        echo"</li>";
                     }
                        
                        
                     if ($current_page < $pageTotal)
                     {
                        echo "<li class='page-item'><a id='".($current_page + 1)."' class='page-link' href='listCoupon.php?page=".($current_page + 1)."'>»</a></li>";
                     }
                        
                  echo "</ul>";
                  echo "</nav>";
            }
            else {
               echo "0 sản phẩm";
            }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
   }
   public function countCoupon()
   {
      try{
         $stmt = $this->db->prepare("SELECT count(*) AS total FROM coupon");
         $stmt->execute();
         $result = $stmt->fetch();

         return $result['total'];
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }   
   }
   public function addCoupon($coupon_code,$date_start,$date_end,$type_coupon, $scale)
   {
      try
         {
            $stmt = $this->db->prepare("INSERT INTO `coupon` (`ID`, `coupon_code`,`type_coupon`, `date_start`, `date_end`, `scale`) 
            VALUES (NULL, :coupon_code,:type_coupon, :date_start, :date_end, :scale)");
            $stmt->bindparam(":coupon_code", $coupon_code);
            $stmt->bindparam(":type_coupon", $type_coupon);
            $stmt->bindparam(":date_start", $date_start);
            $stmt->bindparam(":date_end", $date_end);
            $stmt->bindparam(":scale", $scale);         
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }
   public function deleteCoupon($id)
   {
      try{
         $stmt= $this->db->prepare("DELETE from coupon WHERE id=:id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function showCoupon($id)
   {
      try{
         $stmt= $this->db->prepare("SELECT * FROM coupon WHERE ID = :id");
         $stmt->bindparam(":id", $id);
         $stmt->execute();
         $result = $stmt->fetch();
         echo "<form id='updateFormCoupon'>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Mã giảm giá</label>";
            echo  "<input type='text' id='coupon_codeShow' placeholder='Mã giảm giá' class='form-control' value='".$result['coupon_code']."' />";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Ngày bắt đầu</label>";
            echo  "<input type='date' id='date_startShow' class='form-control' value='".date('Y-m-d',strtotime($result['date_start']))."'/>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Ngày kết thúc</label>";
            echo  "<input type='date' id='date_endShow' class='form-control' value='".date('Y-m-d',strtotime($result['date_end']))."'/>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Loại giảm giá</label>";
            echo" <select type='number' id='type_couponShow' class='form-select'>";
                  echo "<option value='".$result['type_coupon']."'>";
                  if($result['type_coupon']==0){
                     echo "Giảm theo %";
                  }else{
                     echo "Giảm tiền";
                  }
                  echo "</option>";
                  echo "<option value='0'>Giảm theo %</option>";
                  echo "<option value='1'>Giảm tiền</option>";
            echo "</select>";
         echo "</div>";
         echo "<div class='mb-3'>";
            echo  "<label class='form-label'>Mức giảm</label>";
            echo  "<input type='number' id='scaleShow' placeholder='Tên sản phẩm' class='form-control' value='".$result['scale']."' />";
         echo "</div>";
         echo "<div class='modal-footer'>";
            echo "<button type='button' id='".$result['ID']."'  class='clickUpdateCoupon btn btn-warning btn-lg' style='width: 100%;'>Cập nhật</button>";
         echo "</div>";
         echo "</form>";
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         exit;
      }  
   }
   public function updateProduct($id,$coupon_code,$date_start,$date_end,$type_coupon, $scale)
   {
      try
         {
            $stmt = $this->db->prepare("UPDATE coupon 
            SET coupon_code = :coupon_code, 
               type_coupon = :type_coupon, 
               date_start = :date_start, 
               date_end = :date_end, 
               scale = :scale
               WHERE ID = :id");
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":coupon_code", $coupon_code);
            $stmt->bindparam(":type_coupon", $type_coupon);
            $stmt->bindparam(":date_start", $date_start);
            $stmt->bindparam(":date_end", $date_end);
            $stmt->bindparam(":scale", $scale);         
            $stmt->execute(); 
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            exit;
         }    
   }
}
?>