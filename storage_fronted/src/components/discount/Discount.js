import React from "react"
import Dcard from "./Dcard"

const Discount = ({products}) => {
  return (
    <>
      <section className='Discount background NewArrivals'>
        <div className='container'>
          <div className='heading d_flex'>
            <div className='heading-left row  f_flex'>
                <div>
                    <img src='https://img.icons8.com/windows/32/fa314a/gift.png' />
                    <h2>Big Discounts</h2>
                </div>
            </div>
            <div className='heading-right row '>
              <span>View all <i className='fa-solid fa-caret-right'></i></span>
              
            </div>
          </div>
          <Dcard products={products} />
        </div>
      </section>
    </>
  )
}

export default Discount