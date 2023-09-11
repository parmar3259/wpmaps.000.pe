<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../database/connection.php');

require '../mail/PHPMailer/src/PHPMailer.php';
require '../mail//PHPMailer/src/SMTP.php';
require '../mail//PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// echo "<pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Perform server-side validation and sanitization for each field
    $user_id = isset($_POST['user_id']) ? htmlentities($_POST['user_id']) : '';
    $user_email = isset($_POST['user_email']) ? htmlentities($_POST['user_email']) : '';
    $invoiceNumber = isset($_POST['invoiceNumber']) ? htmlentities($_POST['invoiceNumber']) : '';
    $fullname = isset($_POST['user_name']) ? htmlentities($_POST['user_name']) : '';
    $combined_address = isset($_POST['combined_address']) ? htmlentities($_POST['combined_address']) : '';

    // Deserialize and validate the cart data
    $cart_data = isset($_POST['cart_data']) ? unserialize($_POST['cart_data']) : array();


    // Function to check if invoice number exists
    function isInvoiceNumberExists($conn, $invoiceNumber)
    {
        $query = "SELECT invoice_id FROM orders WHERE invoice_id = '$invoiceNumber'";
        $result = mysqli_query($conn, $query);
        return mysqli_num_rows($result) > 0;
    }

    // Generate a random digit from 1 to 10
    function generateRandomDigit()
    {
        return rand(1, 10);
    }

    // Check if the invoice number already exists
    while (isInvoiceNumberExists($conn, $invoiceNumber)) {
        $invoiceNumber .= generateRandomDigit(); // Append a random digit to the invoice number
    }
    $cart_count = count($cart_data);

    $total = 0;
    foreach ($cart_data as $item) {


        if ($item['delivered'] === 'Not Delivered') {
            $quantity = $item['product_Quantity'];
            $rate = $item['product_rate'];
            $subtotal = $quantity * $rate;
            $total += $subtotal;
        }
    }

    $sub_total = number_format($total, 2);
    $total += 20;

    $cart_data = serialize($cart_data);
    $date = date("M. d, Y");
    // echo $date;
    $date_next = date("M. d, Y", strtotime("+5 days"));
    // echo $date_next;

    // echo "<pre>";
    // print_r($user_email);
    // print_r($combined_address);


    // print_r($fullname);
    // print_r($cart_data);
    // print_r($invoiceNumber);

    // die;
    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Specify SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'parmar3259@gmail.com';
        $mail->Password = 'leughvmjolmgrlyo';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('parmar3259@gmail.com', 'hardik parmar');
        $mail->addAddress($user_email);

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // $mail->Debugoutput = function ($str, $level) {

        //     echo "Debug level $level; message: $str";
        // };

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your Purchase is Confirmed! Get Set to Unleash Your Style with Phulkari Eva!';


        // $mail->Body = 'This is a test email sent from PHPMailer.';

        // Embed the image in the email
        $mail->Body = '<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">

 <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">

 </div>

 <table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tr>
     <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">

       <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
         <tr>
           <td align="center" height="6" style="background-image: linear-gradient(to right, #b91bAb, #5a3aa5); background-color: #b91bAb;" bgcolor="#b91bAb"></td>
         </tr>
       </table>
       <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:800px;">
       <tr>
       <td align="center" valign="top" style="background-color: #23C467; font-size:0; padding: 35px 35px 0;" bgcolor="#23C467">
         <div class="align-center" style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
           <table class="align-center" align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:800px;">
             <tr>
               <td align="left" height="48" valign="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size:48px; font-weight: 800; line-height: 48px;" class="mobile-center">
                 <h1 style="font-size: 0; line-height: 0; font-weight: 600;  margin: 0; color: #ffffff;"><span></span></h1>
               </td>
             </tr>
           </table>
         </div>
      
         <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;" class="mobile-hide">
           <table align="right" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
             <tr>
               <td align="right" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
                 <table cellspacing="0" cellpadding="0" border="0" align="right">
                  
                 </table>
               </td>
             </tr>
           </table>
         </div>
       </td>
     </tr>
     
         <tr>
           <td align="center" style="padding: 0 15px 20px 15px; background-color: #ffffff;" bgcolor="#ffffff">
          
             <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
               <tr>
                 <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                   <img src="https://phulkarieva.live/user/assets/images/tickmark.png" width="125" height="120" style="display: block; border: 0px;" /><br>
                   <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                             Thank You For Your Order!
                         </h2>
                 </td>
               </tr>
               <tr>
                 <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                   <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777; padding: 0 30px;">
                   We are thrilled to confirm your purchase and appreciate your business. Below, you will find the details of your order:
                   </p>
                 </td>
               </tr>
               <tr>
                 <td align="left" style="padding-top: 20px;">
                   <table cellspacing="0" cellpadding="0" border="0" width="100%">
                     <tr>
                       <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                         Invoice #
                       </td>
                       <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                         ' . $invoiceNumber . '
                       </td>
                     </tr>
                     <tr>
                       <td width="45%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                         Order Date
                       </td>
                       <td width="55%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;">
                       ' . $date . '
                       </td>
                     </tr>
                     <tr>
                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                         Customer
                       </td>
                       <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 5px 10px;">
                       ' . $fullname . '
                       </td>
                     </tr>
               
                     <tr>
                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; line-height: 24px; padding: 20px 10px 5px 10px;">
                         <span style="font-style: italic;">Purchased Item</span> (' . $cart_count . ')
                       </td>
                       <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 20px 10px 5px 10px;">
                       ₹' . $sub_total . '
                       </td>
                     </tr>
                     <tr>
                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                         Shipping + Handling
                       </td>
                       <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 600; line-height: 24px; padding: 5px 10px;">
                       ₹20.00
                       </td>
                     </tr>
                  
                   </table>
                 </td>
               </tr>
               <tr>
                 <td align="left" style="padding-top: 20px;">
                   <table cellspacing="0" cellpadding="0" border="0" width="100%">
                     <tr>
                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 2px solid #eeeeee; border-bottom: 2px solid #eeeeee;">
                         TOTAL
                       </td>
                       <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 2px solid #eeeeee; border-bottom: 2px solid #eeeeee;">
                       ₹' . $total .'.00
                       </td>
                     </tr>
                   </table>
                 </td>
               </tr>
             </table>
       
           </td>
         </tr>
         <tr>
           <td align="center" height="100%" valign="top" width="100%" style="padding: 0 15px 5px 15px; background-color: #ffffff;" bgcolor="#ffffff">
          
             <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
               <tr>
                 <td align="center" valign="top" style="font-size:0;">
                 
                   <div class="mw-50" style="display:inline-block; padding-bottom: 15px; vertical-align:top; width:100%;">

                     <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                       <tr>
                         <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 0 10px;">
                           <p style="font-weight: 800;">Delivery Address</p>
                           <p>  ' . $combined_address . '</p>
                         </td>
                       </tr>
                     </table>
                   </div>
            
                   <div class="mw-50" style="display:inline-block; padding-bottom: 15px; vertical-align:top; width:100%;">
                     <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                       <tr>
                         <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 0 10px;">
                           <p style="font-weight: 800;">Estimated Delivery Date</p>
                           <p>  ' . $date_next . ' </p>
                         </td>
                       </tr>
                     </table>
                   </div>
                
                 </td>
               </tr>
             </table>
    
           </td>
         </tr>      
         <tr>
           <td align="center" style="padding: 35px 35px 15px; background-color: #ffffff;" bgcolor="#ffffff">
         
           <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
  <tr>
    <td align="center" style="line-height: 0;">
      <img src="https://phulkarieva.live/user/assets/images/thankyou.png" width="200" height="200" style="display: block; border: 0px;" />
    </td>
  </tr>
</table>

            
           
           </td>
         </tr>
       </table>
       
     </td>
   </tr>
 </table>

</body> ';







        $sql = "INSERT INTO orders (user_id, user_email, invoice_id, cart_data, date) 
            VALUES ('$user_id', '$user_email', '$invoiceNumber', '$cart_data', NOW())";

        if (mysqli_query($conn, $sql)) {
            $deleteCartQuery = "DELETE FROM cartdata WHERE user_id = '$user_id'";
            if (mysqli_query($conn, $deleteCartQuery)) {

                $mail->send();
                // echo "done";
            } else {
                echo "Error deleting cart data: " . mysqli_error($conn);
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } catch (Exception $e) {
        echo 'Error: ' . $mail->ErrorInfo;
    }
}










?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>phulkari eva - Contact</title>
    <?php
    include('./cssfiles.php');
    ?>
</head>

<body>



    <!-- Header -->
    <?php
    include('./navbar.php');



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Perform server-side validation and sanitization for each field
      $user_id = isset($_POST['user_id']) ? htmlentities($_POST['user_id']) : '';
      $user_email = isset($_POST['user_email']) ? htmlentities($_POST['user_email']) : '';
      $invoiceNumber = isset($_POST['invoiceNumber']) ? htmlentities($_POST['invoiceNumber']) : '';
      $fullname = isset($_POST['user_name']) ? htmlentities($_POST['user_name']) : '';
      $combined_address = isset($_POST['combined_address']) ? htmlentities($_POST['combined_address']) : '';
  
      // Deserialize and validate the cart data
      $cart_data = isset($_POST['cart_data']) ? unserialize($_POST['cart_data']) : array();
    
    
    
 
      $cart_count = count($cart_data);

      $total = 0;
      foreach ($cart_data as $item) {


          if ($item['delivered'] === 'Not Delivered') {
              $quantity = $item['product_Quantity'];
              $rate = $item['product_rate'];
              $subtotal = $quantity * $rate;
              $total += $subtotal;
          }
      }

      $sub_total = number_format($total, 2);
      $total += 20;

      $cart_data = serialize($cart_data);
      $date = date("M. d, Y");
      // echo $date;
      $date_next = date("M. d, Y", strtotime("+5 days"));
      $date_next_add = date("M. d, Y", strtotime("+8 days"));

      
      
      
      
    
    }
    ?>
<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
    <thead>
      <tr>
        <!-- <th style="text-align:left;"><img style="max-width: 150px;" src="" alt="Phulkari eva"></th> -->
        <th style="text-align:left;">Phulkarieva</th>

        <th style="text-align:right;font-weight:400;"><?php echo $date;  ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Order status</span><b style="color:green;font-weight:normal;margin:0">Success</b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Payment status</span><b style="color:red;font-weight:normal;margin:0">Not done</b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Invoice ID</span><?php echo $invoiceNumber;  ?></p>
          <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span> Rs. <?php echo $total;  ?>.00</p>
        </td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> <?php echo $fullname;  ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> <?php echo $user_email;  ?></p>
          <!-- <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> +91-1234567890</p> -->
          <!-- <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">ID No.</span> 2556-1259-9842</p> -->
        </td>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Address</span><?php echo $combined_address;  ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Number of Products</span><?php echo $cart_count;  ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Duration of Delivery</span> <?php echo $date_next;  ?> to <?php echo $date_next_add;  ?> </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Items</td>
      </tr>
      <tr>
        <td colspan="2" style="padding:15px;">
        
                                    <?php
         $sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND user_email = '$user_email'AND invoice_id = '$invoiceNumber'";
         $result = mysqli_query($conn, $sql);

         if (mysqli_num_rows($result) > 0) {


             while ($row = mysqli_fetch_assoc($result)) {

                 $cart_data = unserialize($row['cart_data']);

                                    // Iterate through each item in the cart_data array
                                    foreach ($cart_data as $key => $item) {

                                    
                                      $name = $item['product_name'];
                                        $img = $item['product_image_path'];
                                        $rate = number_format($item['product_rate'], 2);
                                        $size = $item['product_size'];


                                    
                                    ?>
                             <div style="display: flex; align-items: center;">
                      <p style="font-size: 14px; margin: 0; padding: 10px; border: solid 1px #ddd; font-weight: bold; flex: 1;">
                        <span style="display: block; font-size: 13px; font-weight: normal;">
                          <?php echo $name; ?>
                        </span> 
                        Rs. <?php echo $rate; ?><br>
                        Size = <?php echo $size; ?>
                      </p>
                      <div style="position: relative;">
                        <img src="<?php echo $img; ?>" alt="Image" style="width: 50px; height: 50px; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                      </div>
                    </div>


        
                                <?php
                                    }
                                  }
                                }
  
                                    ?>
  
  
          
          
          
          <!-- <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Pickup & Drop</span> Rs. 2000 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Local site seeing with guide</span> Rs. 800 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Tea tourism with guide</span> Rs. 500 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">River side camping with guide</span> Rs. 1500 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Trackking and hiking with guide</span> Rs. 1000 <b style="font-size:12px;font-weight:300;"> /person/day</b></p> -->
        </td>
      </tr>
    </tbody>
    <tfooter>
      <tr>
      <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
          <strong style="display:block;margin:0 0 10px 0;">Regards</strong> Phulkarieva <br> Sector 2, Jai Narayan Vyas Colony, Pin/Zip - 334003, Bikaner, Rajasthan, India<br><br>
          <b>Phone:</b> 9530467006<br>
          <b>Email:</b> info.phulkarieva@gmail.com
        </td>
      </tr>
    </tfooter>
  </table>
</body>

    <?php
    include('./footer.php');
    ?>
</body>

</html>