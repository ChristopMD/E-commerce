import React, {useEffect, useState} from 'react'
import axios from 'axios'
const endpoint = process.env.REACT_APP_API;

const Categories = () => {


  const [categories, setCategories] = useState( [] )
  //const [active, setActive] = useState(true)

    useEffect(()=>{
        getAllCategories()
    },[])
    const getAllCategories =  async() =>{
        const response = await axios.get(`${endpoint}/categories`)
        setCategories(response.data.data)
        console.log(response.data.data)
    }
  
  return (
    <>
        <div className='category'>
          {
            categories.map((category, index)=>{
              return(
                <div className='box f_flex' key={index}>
                  {/* <img src={category.logo} alt='' /> */}
                  <span>{category.name}</span>
                </div>
              )
            })
          }
        </div>
    </>
  )
}

export default Categories