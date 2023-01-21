import React, {useEffect, useState} from 'react'
import axios from 'axios'

import {Link} from 'react-router-dom'

const endpoint = 'http://localhost:8000/api'
const ShowCategories = () => {
    //variable de estado 'categories' y funcion para actualizar 'setCategories'
    const [categories, setCategories] = useState( [] )
    const [active, setActive] = useState(true)

    useEffect(()=>{
        getAllCategories()
    },[])
    const getAllCategories =  async() =>{
        const response = await axios.get(`${endpoint}/categories`)
        setCategories(response.data.data)
        console.log(response.data.data)
    }
    //Can't delete a category if is actived
    const deleteCategory = async(id) =>{

        await axios.delete(`${endpoint}/categories/${id}`).catch(function (error) {
            if (error.response) {
                alert(error.response.data.msg)
                console.log(error.response.data.msg);
                console.log(error.response.status);
            }
          })
          
        getAllCategories()
    }

    // const toggle=(index)=>{
    //     setActiveText(!activeText)
    // }

    const updateStateCategory = async(id)=>{
        try {
            //set the activate state of a category
            setActive(!active)
            await axios.put(`${endpoint}/categories/active/${id}`,{
                is_actived:active
            })
            getAllCategories()
        } catch (error) {
            console.error(error.message);
        }
    }
    //console.log(typeof categories.data)
    return (
        <div>
            <div className='d-grid gap-2'>
                <Link to="/create" className='btn btn-success btn-lg mt-2 mb-2 text-white'>Create</Link>
            </div>
            <table className='table table-striped'>
                <thead className='bg-primary text-white'>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {categories.map((category)=>(
                        <tr key={category.id}>
                            <td>{category.name}</td>
                            <td>{category.description}</td>
                            <td>    
                                <Link to={`/edit/${category.id}`} className = 'btn btn-warning'>Edit</Link>
                                <button onClick={()=>deleteCategory(category.id)} className='btn btn-danger'>Delete</button>
                                <button onClick= {()=>updateStateCategory(category.id)} className='btn btn-primary mb1 bg-orange' >{category.is_actived ? 'Disable':'Activate'}</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
  )
}



export default ShowCategories