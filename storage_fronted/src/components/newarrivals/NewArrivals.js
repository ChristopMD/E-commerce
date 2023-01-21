import React from "react"
import Cart from "./Cart"
import "./style.css"

const NewArrivals = ({products}) => {
  
  return (
    <>
      <section className='NewArrivals background'>
        <div className='container'>
          <div className='heading d_flex'>
            <div className='heading-left row f_flex'>
              <div>
                <img src="../../../images/new_logo.png" alt="logo" />
                <h2> New Arrivals </h2>
              </div>
              
            </div>
            
            <div className='heading-right row '>
                <span>
                View all 
                <i className='fa fa-caret-right'></i>
                </span> 
                
            </div>
          </div>

          <Cart products={products} />
        </div>
      </section>
    </>
  )
}

export default NewArrivals