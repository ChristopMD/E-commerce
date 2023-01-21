import React from "react"

import Slider from "react-slick"

const endpoint = 'http://localhost:8000/api'

const Cart = ({products}) => {
  const settings = {
    dots: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000, //ms
  }
  return (
    <>
      <Slider {...settings}>
        
          {products.map((product, index) => {
            return (
              <div className='box product' key={index}>
                <div className='img'>
                  <img src={`data:image/png;base64,${product.img_url}`} style={{maxWidth: '300px', height:'300px'}} alt='' />
                </div>
                <h4>{product.name}</h4>
                <span>${product.price}</span>
              </div>
            )
          })}
        
      </Slider>
    </>
  )
}

export default Cart