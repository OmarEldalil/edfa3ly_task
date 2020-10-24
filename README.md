# installation and running
```
git clone https://github.com/OmarEldalil/edfa3ly_task
```
cd into the project then composer install, it's just for autoloading 

run "php createCart.php  T-Shirt T-Shirt Jacket Shoes Shoes Jacket"

with currency option 

i.e. "php createCart.php  T-Shirt T-Shirt Jacket Shoes Shoes Jacket T-Shirt T-Shirt --currency=EGP"

# design

- singleton App with container holding needed services throughout the application,
- input interpreter service to interpret the user's input and parse it.
- Products service that loads the products from an array data, and can transform it
- Currency converter service that only convert prices from Default to any currency that loaded through conversion array in Data folder
- Offers module that implement the offer interface (contract) which has two methods, one for checking eligibility and the other for getting the discount
adding new offers as much as you want you have to add implement that contract and register the offer in the available_offers config file
