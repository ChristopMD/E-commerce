import './App.css';
import { BrowserRouter, Routes, Route } from 'react-router-dom';

//importar componentes
import ShowCategories from './components/categories/ShowCategories';
import CreateCategory from './components/categories/CreateCategory';
import EditCategory from './components/categories/EditCategory';
import HomePage from './components/homePage/HomePage';
import Header from './common/header/Header';
import Pages from './pages/Pages';

import React, {useEffect, useState} from 'react'
import axios from 'axios'
import Cart from './common/cart/Cart';
import Footer from './common/footer/Footer';
const endpoint = 'http://localhost:8000/api'

function App() {
  //Products from databse
  const [products, setProducts] = useState( [] )
  
    useEffect(()=>{
        getAllProducts()
    },[])
    const getAllProducts =  async() =>{
        const response = await axios.get(`${endpoint}/products`)
        setProducts(response.data.data)
        //console.log(response.data.data)
    }
    //Products and Brands from database
    const [subategoryId, setSubcategoryId] = useState(8)
    const [productsBySubcategory, setProductsBySubcategory] = useState( [] )
    const [brandsBySubcategory, setBrandsBySubcategory] = useState( [] )
  
    useEffect(()=>{
        getAllProductsBySubcategory()
    },[])
    const getAllProductsBySubcategory =  async() =>{
        const response = await axios.get(`${endpoint}/subcategories/${subategoryId}/products`)
        setProductsBySubcategory(response.data.data)
        //console.log(response.data.data)
    }

    useEffect(()=>{
      getAllBrandsBySubcategory()
  },[])
  const getAllBrandsBySubcategory =  async() =>{
      const response = await axios.get(`${endpoint}/subcategories/${subategoryId}/brands`)
      setBrandsBySubcategory(response.data.data)
      //console.log(response.data.data)
  }


    const [cartItem, setCartItem] = useState([])

    const addToCart = (product) => {
      // if hamro product alredy cart xa bhane  find garna help garxa
      const productExit = cartItem.find((item) => item.id === product.id)
      // if productExit chai alredy exit in cart then will run fun() => setCartItem
      // ani inside => setCartItem will run => map() ani yo map() chai each cart ma
      // gayara check garxa if item.id ra product.id chai match bhayo bhane
      // productExit product chai display garxa
      // ani increase  exits product QTY by 1
      // if item and product doesnt match then will add new items
      if (productExit) {
        setCartItem(cartItem.map((item) => (item.id === product.id ? { ...productExit, qty: productExit.qty + 1 } : item)))
      } else {
        // but if the product doesnt exit in the cart that mean if card is empty
        // then new product is added in cart  and its qty is initalize to 1
        setCartItem([...cartItem, { ...product, qty: 1 }])
      }
    }

    // Stpe: 6
  const decreaseQty = (product) => {
    // if hamro product alredy cart xa bhane  find garna help garxa
    const productExit = cartItem.find((item) => item.id === product.id)

    // if product is exit and its qty is 1 then we will run a fun  setCartItem
    // inside  setCartItem we will run filter to check if item.id is match to product.id
    // if the item.id is doesnt match to product.id then that items are display in cart
    // else
    if (productExit.qty === 1) {
      setCartItem(cartItem.filter((item) => item.id !== product.id))
    } else {
      // if product is exit and qty  of that produt is not equal to 1
      // then will run function call setCartItem
      // inside setCartItem we will run map method
      // this map() will check if item.id match to produt.id  then we have to desc the qty of product by 1
      setCartItem(cartItem.map((item) => (item.id === product.id ? { ...productExit, qty: productExit.qty - 1 } : item)))
    }
  }

  return (
    <div className="App">
      <BrowserRouter>
        <Header cartItem={cartItem} />
        <Routes>
          <Route path = '/' element = {<Pages products={products} addToCart={addToCart} productsBySubcategory={productsBySubcategory} brandsBySubcategory={brandsBySubcategory}/>}/>
          <Route path='/cart' element={<Cart cartItem={cartItem} addToCart={addToCart} decreaseQty={decreaseQty}/>}/>
          <Route path='/categories/create' element={<CreateCategory/>} />
          <Route path='/categories/edit/:id' element={<EditCategory/>} />
        </Routes>
        <Footer />
      </BrowserRouter>
    </div>
  );
}

export default App;
