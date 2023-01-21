import React from 'react'
import axios from 'axios'

import Header from '../../common/header/Header';
import { BrowserRouter, Routes} from 'react-router-dom';
import Categories from './Categories';
import SlideCard from './SlideCard';
import Slider from './Slider';
import './HomePage.css'

const HomePage = () => {

  return (
    <>
      
        <section className='home'>
          <div className='container d_flex'>
            < Categories />
            < Slider />
          </div>
        </section>
        
    </>
  )
}

export default HomePage