<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Card</title>
<link rel="stylesheet" href="CSS/Payment_Design.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container p-0">
        <div class="card px-4">
            <p class="h8 py-3">Card Details</p>
            <form action="saved_card.php" method="post"> <!-- Modified form action -->
                <div class="row gx-3">
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Full Name</p>
                            <input class="form-control mb-3" type="text" name="cardholder_name"> <!-- Added name attribute -->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Card Number</p>
                            <input class="form-control mb-3" type="text" name="card_number"> <!-- Added name attribute -->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Expiry</p>
                            <input class="form-control mb-3" type="text" name="expiry" placeholder="MM/YYYY"> <!-- Added name attribute -->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">CVV/CVC</p>
                            <input class="form-control mb-3 pt-2" type="password" name="cvv" placeholder="***"> <!-- Added name attribute -->
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mb-3" name="save_card"> <!-- Added name attribute -->
                            <span class="ps-3">Save Card</span>
                            <span class="fas fa-arrow-right"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</body>
</html>
