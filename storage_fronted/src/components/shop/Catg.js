import React from "react"

const Catg = ({ brandsBySubcategory }) => {
 
  return (
    <>
      <div className='category'>
        <div className='chead d_flex'>
          <h1>Brands </h1>
          <h1>Technology </h1>
        </div>
        {brandsBySubcategory.map((brand, index) => {
          return (
            <div className='box f_flex' key={index}>
              {/* <img src={value.cateImg} alt='' /> */}
              <span>{brand.brand}</span>
            </div>
          )
        })}
        <div className='box box2'>
          <button>View All Brands</button>
        </div>
      </div>
    </>
  )
}

export default Catg