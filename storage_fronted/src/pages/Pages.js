import React from 'react'
import HomePage from '../components/homePage/HomePage'
import FlashCard from '../components/flashDeals/FlashCard'
import FlashDeals from '../components/flashDeals/FlashDeals'
import TopCate from '../components/top/TopCate'
import NewArrivals from '../components/newarrivals/NewArrivals'
import Discount from '../components/discount/Discount'
import Shop from '../components/shop/Shop'
import Annocument from '../components/annocument/Annocument'
import Wrapper from '../components/wrapper/Wrapper'

const Pages = ({ products, cartItem, addToCart, productsBySubcategory, brandsBySubcategory }) => {
  return (
    <>
        <HomePage cartItem={cartItem}/>
        <FlashDeals products={products} addToCart={addToCart} />
        <TopCate />
        <NewArrivals products={products} />
        <Discount products={products} />
        <Shop productsBySubcategory={productsBySubcategory} brandsBySubcategory={brandsBySubcategory} addToCart={addToCart}/>
        <Annocument />
        <Wrapper />
    </>
  )
}

export default Pages