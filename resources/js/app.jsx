require('./bootstrap');
import React, { Component } from 'react'
import { render } from 'react-dom'
import { Router } from 'react-router-dom'
import history from './helpers/history'
import PrivateRoute from './components/PrivateRoute'
import AuthRoute from './components/AuthRoute'
import Navbar from './components/Navbar'
import Footer from './components/Footer'
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'

class App extends Component {

    render() {

        return (
            <Router history={history}>
                <Navbar />

                <main role="main">
                    <PrivateRoute name="home" path="/" component={Home} exact />
                    <AuthRoute name="register" path="/register" component={Register} />
                    <AuthRoute name="login" path="/login" component={Login} />
                </main>

                <Footer />
            </Router>
        )
    }
}


if (document.getElementById('app')) {
    render(
        <App />,
        document.getElementById('app')
    )
}
