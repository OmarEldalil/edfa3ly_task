# Installation and running
```
git clone https://github.com/OmarEldalil/edfa3ly_task
```
cd into the project then composer install, it's just for autoloading 

run "php createCart.php  T-Shirt T-Shirt Jacket Shoes Shoes Jacket"

with currency option 

i.e. "php createCart.php  T-Shirt T-Shirt Jacket Shoes Shoes Jacket T-Shirt T-Shirt --currency=EGP"

# Main Problems
- Dynamically load user input products and currency into the application
- Plug and play offers and dynamically apply them into carts, check eligibility for it and apply the discount for the cart dynamically
- Converting currency of the cart and load them dynamically 

# design
It built with EXTENSIBILITY in mind 

- Singleton App class with container holding needed services throughout the application
- Input interpreter service to interpret the user's input and parse it, get the producs' list and any other options.
- Products service that loads the products from an array data, and can transform it (this service could be tweaked to load products from another data source like db)
- Offers module with a plug and play OffersService interface that is highly extensible and configurable through a config file. An Offer implements the offer interface (contract) which has two methods, one for checking eligibility and the other for getting the discount.
plugging a new offers as easy as creating an Offer class implements that contract and register the offer in the available_offers config file. The main reason for that is EXTENSIBILITY and easeness of loading multiple offers, separating its logic from the Cart totally. also configuring adding them totally or not through the config file.
- Cart with single responsibility of handling its calculations and separating its logic from the application
- Currency converter service which has a single responsibility of only converting prices from default currency to any currency that loaded through conversion array in Data folder

- Error handling through simple Exception throwing (could be enhanced and Implements my own mechanism with pre-defined Error codes and Messages but got no time)
