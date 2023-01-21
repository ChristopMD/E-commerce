import React from 'react'
import FlashCard from './FlashCard'

const FlashDeals = ({products, addToCart}) => {
  return (
    <>
        <section className='flash background'>
            <div className='container'>
                <div className='heading f_flex'>
                    <i className='fa fa-bolt'></i>
                    <h1>Flash Deals</h1>
                </div>
                <FlashCard products={products} addToCart={addToCart}/>
            </div>
        </section>
    </>
  )
}

export default FlashDeals