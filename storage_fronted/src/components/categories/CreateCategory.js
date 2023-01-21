import axios from 'axios'
import React, {useState} from 'react'
import { useNavigate } from 'react-router-dom'

const endpoint = 'http://localhost:8000/api/categories'

const CreateCategory = () => {

    const [name, setName] = useState('')
    const [description, setDescription] = useState('')
    const navigate = useNavigate();

    const store = (e) => {
        e.preventDefault()
        axios.post(endpoint, {name: name, description:description})
        navigate('/')
    }

  return (
    <div>
        <h3>Create Category</h3>
        <form onSubmit={store}>
            <div className='mb-3'>
                <label className='form-label'>Name</label>
                <input 
                value={name} 
                onChange={(e)=>setName(e.target.value)}
                type='text'
                className='form-control'
                />
            </div>
            <div className='mb-3'>
                <label className='form-label'>Description</label>
                <input 
                value={description} 
                onChange={(e)=>setDescription(e.target.value)}
                type='text'
                className='form-control'
                />
            </div>
            <button type='submit' className='btn btn-primary'>Store</button>
        </form>
    </div>
  )
}

export default CreateCategory
