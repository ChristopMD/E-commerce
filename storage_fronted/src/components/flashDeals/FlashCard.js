import React, {useEffect, useState} from 'react'
import axios from 'axios'
import Slider from 'react-slick'

const endpoint = 'http://localhost:8000/api'

const FlashCard = ({products, addToCart}) => {
    // const [products, setProducts] = useState( [] )
    
    // useEffect(()=>{
    //     getAllProducts()
    // },[])
    // const getAllProducts =  async() =>{
    //     const response = await axios.get(`${endpoint}/products`)
    //     setProducts(response.data.data)
    //     console.log(response.data.data)
    // }
    const NextArrow =(props)=>{
        const {onClick} = props;
        return(
            <div className='control-btn' onClick={onClick}>
                <button className='next'>
                    <i className='fa fa-long-arrow-alt-right'></i>
                </button>
            </div>
        )
    }
    const PrevArrow =(props)=>{
        const {onClick} = props;
        return(
            <div className='control-btn' onClick={onClick}>
                <button className='prev'>
                    <i className='fa fa-long-arrow-alt-left'></i>
                </button>
            </div>
        )
    }

    const [count, setCount] = useState(0);
    const increment = () => {
        setCount(count + 1)
    }

    const settings = {
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow: <NextArrow />,
        prevArrow: <PrevArrow />
        
      };
  return (
    <>
        <Slider {...settings}>
            {products.map((product, index)=>{
                return(
                <div className='box' key={index}>
                    <div className='product mtop'> {/* bug scroll down */}
                        <div className='img'>
                            <span className='discount'>20% Off</span>
                            <img src={`data:image/png;base64,${product.img_url}`} style={{maxWidth: '300px', height:'300px'}} alt='' />
                            <div className='product-like'>
                                <label>{count}</label> <br/>
                                <i className='fa-regular fa-heart' onClick={increment}></i>
                            </div>
                        </div>
                        <div className='product-details'>
                            <h3>{product.name}</h3>
                            <div className='rate'>
                                <i className='fa fa-star'></i>
                                <i className='fa fa-star'></i>
                                <i className='fa fa-star'></i>
                                <i className='fa fa-star'></i>
                                <i className='fa fa-star'></i>
                            </div>
                            <div className='price'>
                                <h4>S/. {product.price}</h4>
                                <button onClick={()=>addToCart(product)}>
                                    <i className='fa fa-plus'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )})}
        </Slider>
    </>
  )
}

export default FlashCard