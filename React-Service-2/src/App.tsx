import { useEffect, useState } from 'react'
import Spinner from './components/Spinner.tsx'
import './App.css'

function App() {
  const [authenticated, setAuthenticated] = useState<boolean>((function (){
    const isAutenticated = localStorage.getItem('auth');
    if(isAutenticated === 'authenticated'){
      return true
    } else {
      return false
    }
  })());
  const [loading, setLoading] = useState<boolean>(true);
  const setAuth = async () => {
    const res = await fetch("http://sso.microservice.test:8000/check-auth",{
        credentials: "include",
    })
    const data = await res.json()
    console.log(data)
    if(data?.authenticated){
        setAuthenticated(true)
        localStorage.setItem('auth', 'authenticated')
      } else {
        setAuthenticated(false)
        localStorage.removeItem('auth')
    }
    setLoading(false);
  }
  const gotoDashboard = () => {
    location.href = "http://sso.microservice.test:8000/dashboard"
  }
  const handleLogout = async () => {
    location.href = "http://sso.microservice.test:8000/token-logout"
  }
  const gotoLogin = async () => {
    location.href = `http://sso.microservice.test:8000/login?next=http://service2.microservice.test:8000/`
  }
  useEffect(() => {
    setAuth()

  }, [])
  return (
    <>
    {loading? (
      <div><Spinner show={true}/></div>
    ): (
      <>
      {authenticated? (
        <div className='mb-12'>
        <button className='mr-3' onClick={gotoDashboard}>Dashboard</button>
        <button onClick={handleLogout}>Logout</button>
      </div>
      ): (
        <div className='mb-12'>
        <button className='mr-3' onClick={gotoLogin}>Login</button>
        <button>Register</button>
      </div>
      )}
      <h1>Vite + React</h1>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
      </>
    )}
    </>
  )
}

export default App
