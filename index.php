<?php

  $invalidInputWarning = "";

  /*************************************************
  *     BEGINS PROCESSING OF THE INPUT STRINGS     *
  **************************************************/

  function checkStrings($str1, $str2){
    if(validateInput($str1) && validateInput($str2))
      compareStrings($str1, $str2);
    else
      invalidInput();
  }


  /*************************************************
  *    VALIDATES STRING AS NON-NULL & BELOW MAX    *
  **************************************************/

  function validateInput($string){
    $check = false;
    if(strlen($string) <= 1000 && strlen($string) > 0){
      $check = true;
    }

    return $check;
  }


  /*************************************************
  *         FORMATS STRING FOR COMPARISON          *
  **************************************************/

  function formatString($string){

    $counter = substr_count($string, '#');
    $c = $counter + 1;
    //This counter helps get length of array after explode
    //can also just calculate the length of stringArray after this point though

    $stringArray = explode('#', $string, $c);

    if($counter >= 1){
      foreach($stringArray as $key => $value){
        $length = strlen($stringArray[$key]);
        $l = $length-1;

        if($length >= 1){
          if($key < $counter){ //Makes sure final char is not deleted
            $stringArray[$key] = substr($stringArray[$key], 0, $l);
            //removes last char from each array element (except last element)
          }
        }
      }
    }


    $finalizedString = implode($stringArray);//Reformat array into string

    return $finalizedString;
  }


  /*************************************************
  *   COMPARES TWO VALID STRINGS WITH EACH OTHER   *
  **************************************************/

  function compareStrings($string1, $string2){
    $newString1 = formatString($string1);
    $newString2 = formatString($string2);

    $result = false;
    if(strcmp($newString1, $newString2) == 0){
      $result = true;
    }

    ?>
    <section class="flex-container row resultStrings">
      <div class="col col-2">
        <p class="finalString1"><?=$newString1?></p>
      </div>
      <div class="col col-2">
        <p class="finalString2"><?=$newString2?></p>
      </div>
    </section>
    <section class="row results">
      <div class="col col-4">
        <p class="result">
          <?php
          if($result == true){
            ?>
            The above strings are identical to each other
            <?php
          }
          else{
            ?>
            The above strings are not identical to each other
            <?php
          }
          ?>
        </p>
      </div>
    </section>

    <?php
  }

  function invalidInput(){
    $invalidInputWarning = '<p class="warning">** Process Failure - Input not in Proper Format **</p><br>';
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>String Comparison</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header>
    <h1>String Comparison Practice</h1>
    <p>
      Processing Logic: Every time a pound symbol (#) appears within either input string, the character directly before it will be deleted along with the symbol itself.<br>
      Once completed, the two strings will be compared in a case sensitive manner to see if they are equal.
    </p>
  </header>
  <main>
    <h1>Enter Two Strings Below</h1>
      <form>
        <section class="flex-container row input">
          <div class="col col-2">
            <label for="lString">First String:</label><br>
            <input type="text" id="lString" name="lString">
          </div>

          <div class="col col-2">
            <label for="rString">Second String:</label><br>
            <input type="text" id="rString" name="rString">
          </div>
        </section>

        <section class="row submit">
          <div class="col col-4">
            <input type="submit">
          </div>
        </section>
      </form>
      <?php
        if(isset($_GET['lString']) && isset($_GET['rString']))
          checkStrings($_GET['lString'], $_GET['rString']);
        else if($invalidInputWarning != "")
          echo $invalidInputWarning;
      ?>
  </main>
</body>
</html>
