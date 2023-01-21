import React from "react"
import Slider from "react-slick"
import "slick-carousel/slick/slick.css"
import "slick-carousel/slick/slick-theme.css"
import Ddata from "./Ddata"
import "../newarrivals/style.css"

const Dcard = ({products}) => {
  const settings = {
    dots: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000, //ms
  }
  return (
    <>
      <Slider {...settings}>
        {products.map((product, index) => {
          return (
              <div className='box product' key={index}>
                <div className='img'>
                  <img src={`data:image/png;base64,${product.img_url}`} style={{maxWidth: '300px', height:'300px'}} alt='' width='100%' />
                </div>
                <h4>{product.name}</h4>
                <span>{product.price}</span>
              </div>
          )
        })}
      </Slider>
    </>
  )
}

export default Dcard