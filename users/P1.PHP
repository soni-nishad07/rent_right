// File upload logic
   $uploads_dir = '../uploads';
   $uploaded_files = [];
   
   if (!empty($_FILES['file_upload']['name'][0])) {
       foreach ($_FILES['file_upload']['name'] as $key => $name) {
           $tmp_name = $_FILES['file_upload']['tmp_name'][$key];
   
           // Generate a unique 6-character file name
           $file_ext = pathinfo($name, PATHINFO_EXTENSION);
           $file_name = 'pro_' . substr(uniqid(), -4) . '.' . $file_ext; // Shortened unique ID
           $file_path = "$uploads_dir/$file_name";
   
           // Move the file to the uploads directory
           if (move_uploaded_file($tmp_name, $file_path)) {
               $uploaded_files[] = $file_path;
           }
       }
   }
   
   $file_paths = sanitize(implode(',', $uploaded_files)); // Sanitize file paths















   <!-- --------------------- -->

   // File upload logic
$uploads_dir = '../uploads';
$uploaded_files = [];

if (!empty($_FILES['file_upload']['name'][0])) {
    foreach ($_FILES['file_upload']['name'] as $key => $name) {
        $tmp_name = $_FILES['file_upload']['tmp_name'][$key];

        // Generate a unique 6-character file name
        $file_ext = pathinfo($name, PATHINFO_EXTENSION);
        $file_name = 'pro_' . substr(uniqid(), -4) . '.' . $file_ext; // Shortened unique ID
        $file_path = "$uploads_dir/$file_name";

        // Move the file to the uploads directory
        if (move_uploaded_file($tmp_name, $file_path)) {
            $uploaded_files[] = $file_path;
        }
    }
}

$file_paths = sanitize(implode(',', $uploaded_files)); // Sanitize file paths

