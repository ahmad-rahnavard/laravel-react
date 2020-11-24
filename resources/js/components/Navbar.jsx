import React, { Component } from 'react'
import { NavLink } from 'react-router-dom'
import store from '../store/_store'
import history from '../helpers/history'

export default class Navbar extends Component {

    constructor(props) {
        super(props)

        this.state = {
            isLoggedIn: store.getState().isLoggedIn
        }

        store.subscribe(() => {
            this.setState({
                isLoggedIn: store.getState().isLoggedIn
            })
        })

        this.logoutHandler = this.logoutHandler.bind(this)
        this.accountLinks = this.accountLinks.bind(this)
    }

    logoutHandler() {
        localStorage.removeItem('user')
        store.dispatch({ type: 'LOGOUT' })

        return history.push('/login')
    }

    accountLinks() {

        const loggedInLinks = () => (
            <li className="nav-item">
                <a className="nav-link btn" onClick={this.logoutHandler}>Logout</a>
            </li>
        )

        const loggedOutLinks = () => (
            <>
                <li className="nav-item">
                    <NavLink className="nav-link" to="/login">Sign in</NavLink>
                </li>
                <li className="nav-item">
                    <NavLink className="nav-link" to="/register">Sign up</NavLink>
                </li>
            </>
        )

        return this.state.isLoggedIn ? loggedInLinks() : loggedOutLinks()
    }

    render() {

        return (
            <nav className="navbar navbar-expand-md navbar-light fixed-top bg-white">
                <div className="container">
                    <NavLink className="navbar-brand" to="/">
                        <img src={'images/logo.svg'} alt="logo" />
                    </NavLink>
                    <div className="d-flex ml-auto">
                        <button className="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#globalNavbar" aria-controls="globalNavbar" aria-expanded="false"
                            aria-label="Toggle navigation"><span className="navbar-toggler-icon" /></button>
                    </div>
                    <div className="collapse navbar-collapse" id="globalNavbar">
                        <ul className="navbar-nav mr-auto">
                            <li className="nav-item">
                                <NavLink className="nav-link" to="/">Home</NavLink>
                            </li>
                        </ul>
                        <ul className="navbar-nav d-none d-lg-flex ml-2">
                            {this.accountLinks()}
                        </ul>
                        <ul className="navbar-nav d-lg-none">
                            <li className="nav-item-divider" />
                            {this.accountLinks()}
                        </ul>
                    </div>
                </div>
            </nav>
        )
    }
}
