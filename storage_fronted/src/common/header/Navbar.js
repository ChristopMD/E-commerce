import React, { useState } from 'react'
import { Link } from 'react-router-dom'
import './Header.css'

const Navbar = () => {

  const [MobileMenu, setMobileMenu]=useState(false)
  return (
    <>
        <header className='header'>
          <div className='container d_flex'>
            <div className='catgrories d_flex no_wrap'>
              <span className='fa-solid fa-border-all'></span>
              <h4>
                Categories <i className='fa fa-chevron-down'></i>
              </h4>
            </div>
            <div className='navnlink'>
              <ul className={MobileMenu ? 'nav-links-MobileMenu' : 'link f_flex capitalize'} onClick={()=>setMobileMenu(false)}>
                <li>
                  <Link to='/' style={{ color: 'black', textDecoration: 'none' }}>home</Link>
                </li>
                <li>
                  <Link to='/pages' style={{ color: 'black', textDecoration: 'none' }}>pages</Link>
                </li>
                <li>
                  <Link to='/user' style={{ color: 'black', textDecoration: 'none' }}>user account</Link>
                </li>
                <li>
                  <Link to='/vendor' style={{ color: 'black', textDecoration: 'none' }}>vendor account</Link>
                </li>
                <li>
                  <Link to='/track' style={{ color: 'black', textDecoration: 'none' }}>track my order</Link>
                </li>
                <li>
                  <Link to='/contact' style={{ color: 'black', textDecoration: 'none' }}>contact</Link>
                </li>
              </ul>
              <button className='toggle' onClick={()=>setMobileMenu(!MobileMenu)}>
                {
                  MobileMenu ? <i className='fas fa-times close home-btn'></i> : 
                  <i className='fas fa-bars open'></i>
                }
              </button>
            </div>
          </div>
        </header>
    </>
  )
}

export default Navbar