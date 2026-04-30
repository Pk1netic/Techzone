<!--This script is responsible for displaying the categories checklist in the category filter card
and store the categories checked and submitted to an array and use it to only display the products from
the categories selected.-->

<?php
    //including the connection.php script to enable connection to our database.
    require_once 'PhpScripts/connection.php';

    //connecting the query to the database. This query will be used to check 
    $result = $conn->query("SELECT * FROM product");

    //If the number of rows/records stored in the product table is greater than 0 create the product's product card
    if($result->num_rows > 0){

        //interating through the product table to return the categories and insert them in the filter's checklist
        while($categorylist = $result->fetch_assoc()) {

            $checked = array(); //array to store products checked by the user
            //if categories are checked then add it to the list
            if(isset($_GET['categories'])){ 
                $checked = $_GET['categories'];
            }
?>
            <!--Inserting category details into the checklist and saving the state of the checked boxes post submission-->
            <div>
                <input type="checkbox" name="categories[]" value="<?php echo $categorylist['Category']; ?>"
                <?php if(in_array($categorylist['Category'],$checked)){
                    echo "checked"; //if the category is is in the $checked list then set its state to "checked".
                } ?>                            
                />
                <?php echo $categorylist['Category']; ?> <!--prints the categories names-->
            </div>
            <?php
        }
    }
    //print out an error message if no categories were found
    else{
        echo "No categories found.";
    }
?>