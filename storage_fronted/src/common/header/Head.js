import React from 'react'
import './Header.css'

const Head = () => {
  return (
    <>
        <section className="head">
            <div className='container d_flex'>{/* className='container d_flex' agrega una sangria en la izquierda */}
                <div>{/* className='left row' salta al siguiente espacio */}
                    <i className='fa fa-phone'></i>
                    <label >+51 999 999 999</label>
                    <i className='fa fa-envelope'></i>
                    <label>example@gmail.com</label>
                </div> 
                <div className='right now RText'>
                    <label>Theme FAQ's</label>
                    <label>Need Help?</label>
                    <span>🔳</span>
                    <label>EN</label>
                    <span>🔳</span>
                    <label>USD</label>
                </div>
            </div>
        </section>
    </>
  )
}

export default Head