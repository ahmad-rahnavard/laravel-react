import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import store from '../store/_store'

export default class Login extends Component {

    constructor(props) {
        super(props)

        this.state = {
            email: '',
            password: '',
            isLoading: false,
            errors: {
                email: '',
                password: ''
            },
            message: '',
        }

        this.changeHandler = this.changeHandler.bind(this)
        this.loginHandler = this.loginHandler.bind(this)
    }

    changeHandler(e) {
        let { name, value } = e.target
        this.setState({ [name]: value })
    }

    loginHandler(e) {
        e.preventDefault()

        this.setState({
            isLoading: true,
            errors: {
                email: '',
                password: ''
            }
        })

        const { email, password } = this.state
        window.axios.post('login', { email, password })
            .then(response => {

                this.setState({ isLoading: false })

                if (response.data.code === 200) {
                    localStorage.setItem('user', JSON.stringify(response.data.data))
                    store.dispatch({ type: 'LOGIN_SUCCESS', user: response.data.data.user })

                    return this.props.history.push('/')
                }
            }).catch(error => {
            this.setState({ isLoading: false })
            if (error.response.data.code === 422) {

                this.setState({
                    errors: {
                        email: error.response.data.errors.email,
                        password: error.response.data.errors.password
                    }
                })

            } else if (error.response.data.code === 401) {

                this.setState({
                    message: error.response.data.message
                })

            } else {
                console.log(error.response)
            }
            store.dispatch({ type: 'LOGIN_FAILURE'})
        })
    }

    render() {
        const isLoading = this.state.isLoading

        return (
            <div className="text-center pt-5">
                <form className="user-form">
                    <img className="mb-4" src={'images/logo.svg'} alt="" width="200" height="72" />
                    <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
                    <div className="form-group">
                        <label htmlFor="email" className="sr-only">Email address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            className="form-control"
                            placeholder="Email address"
                            required=""
                            autoFocus=""
                            value={this.state.email}
                            onChange={this.changeHandler} />
                        <span className="text-danger">{this.state.errors.email}</span>
                    </div>
                    <div className="form-group">
                        <label htmlFor="password" className="sr-only">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            className="form-control"
                            placeholder="Password"
                            required=""
                            value={this.state.password}
                            onChange={this.changeHandler} />
                        <span className="text-danger">{this.state.errors.password}</span>
                    </div>
                    <p className="text-danger">{this.state.message}</p>
                    <button
                        id="loginBtn"
                        className="btn btn-lg btn-primary btn-block"
                        onClick={this.loginHandler}>
                        Sign in
                        {isLoading && (
                            <span
                                className="spinner-border spinner-border-sm ml-5"
                                role="status"
                                aria-hidden="true" />
                        )}
                    </button>
                    <Link
                        id="newAccountBtn"
                        className="btn btn-lg btn-block btn-outline-primary"
                        to="/register"
                    >
                        Create an account.
                    </Link>
                </form>
            </div>
        )
    }
}
