<?php
// Retrieve the selected assessment ID from the AJAX request
$questionId = $_POST['questionId'];
$updatedContent = '';
if ($questionId == 0) {
    // MCQ
    $updatedContent .= '<br><br>
    <label for="idOptions">MCQ Options:</label> <br>
    <div class="form-group" id="inputFields">
        <input type="text" id="0" class="ansOptions" name="options" /><br>
    </div>
    <button type="button" id="addField">Add new option</button>
    <br><br>
    <label for="myFile">Files:</label>
    <input type="file" id="myFile" name="filename">
    <br><br>';
} elseif ($questionId == 1) {
    // FIB
    $updatedContent .= '<br><br>
        <label for="myFile">Files:</label>
        <input type="file" id="myFile" name="filename"> <br><br>';
} elseif ($questionId == 2) {
    // Dropdown
    $updatedContent .= '<br><br>
        <label for="idOptions">DropDown Options:</label><br>
        <div class="form-group" id="input-container">
        <input type="text" id="0" class="ansOptions" name="options" /><br>
        </div>
        <button type="button" class="add-input">+</button>
        <br><br>
        <label for="myFile">Files:</label>
        <input type="file" id="myFile" name="filename"><br><br>';
} else {
    // In case the assessment ID is not found or an error occurs, you can return an error message or default content
    $updatedContent = '<h6>Select question type before continuing</h6>';
}
echo $updatedContent;
// $updatedContent = '
// <label for="questionText">Question Text:</label><br>
// <textarea id="questionText" name="description" rows="5" cols="30" ></textarea><br><br>
// <label for="idAns">Answer:</label>
// <input type="text" id="idAns" name="answer" />';
// // Generate the HTML content based on the fetched data, should have three different form
// if ($questionId == 0) {
//     // MCQ
//     $updatedContent .= '<br><br>
//     <label for="idOptions">MCQ Options:</label> <br>
//     <div class="form-group" id="input-container">
//         <input type="text" id="0" class="ansOptions" name="options"/><br>
//     </div>
//     <button type="button" id="add-input">+</button>
//     <button type="button" id="remove-input">-</button>
//     <br><br>
//     <label for="myFile">Files:</label>
//     <input type="file" id="myFile" name="filename"> <br><br>';
// } elseif ($questionId == 1) {
//     // FIB
//     $updatedContent .= '<br><br>
//     <label for="myFile">Files:</label>
//     <input type="file" id="myFile" name="filename"> <br><br>';    
// } elseif ($questionId == 2) {
//     // Dropdown
//     $updatedContent .= '<br><br>
//     <label for="idOptions">DropDown Options:</label><br>
//     <div class="form-group" id="input-container">
//         <input type="text" id="0" class="ansOptions" name="options" /><br>
//     </div>
//     <button type="button" class="add-input">+</button>
//     <br><br>
//     <label for="myFile">Files:</label>
//     <input type="file" id="myFile" name="filename"><br><br>';
// } else {
//     // In case the assessment ID is not found or an error occurs, you can return an error message or default content
//     $updatedContent = '<h6>Select question type before continuing</h6>';
// }
// echo $updatedContent;
// <script>
//         $(document).ready(function() {
//                 //should allow user to add more options for dropdown questions
//                 $(".add-row").click(function(){
//                     var $clone = <?php $input = "<input type="text" id="idOptions" class="ansOptions" name="options" required/><br>";
//                     echo $input;?
//                     $clone.append("<button type="button" class="remove-row">-</button>");
//                     $clone.insertBefore(".add-row");
//                 });
                
//                 $(".questionForm").on("click", ".remove-row", function(){
//                     $(this).parent().remove();
//                 });
//         });
//     </script>
