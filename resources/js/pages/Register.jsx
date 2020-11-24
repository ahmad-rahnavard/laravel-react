import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import store from '../store/_store'

export default class Register extends Component {

    constructor(props) {
        super(props)

        this.state = {
            isLoading: false,
            signupData: {
                name: '',
                email: '',
                password: '',
            },
            message: '',
        }

        this.changeHandler = this.changeHandler.bind(this)
        this.submitHandler = this.submitHandler.bind(this)
    }

    changeHandler(e, key) {
        const { signupData } = this.state
        signupData[e.target.name] = e.target.value
        this.setState({ signupData })
    }

    submitHandler(e) {
        e.preventDefault()

        this.setState({ isLoading: true })

        window.axios.post('register', this.state.signupData)
            .then((response) => {
                this.setState({ isLoading: false })
                if (response.data.code === 200) {
                    let { name, email } = this.state.signupData
                    store.dispatch({ type: 'REGISTER_SUCCESS', user: { name, email } })
                    this.setState({
                        message: response.data.message,
                        signupData: {
                            name: '',
                            email: '',
                            password: '',
                        },
                    })

                }

            }).catch(error => {
            this.setState({ message: error.response.data.message })
            store.dispatch({ type: 'REGISTER_FAILURE' })
            console.log(error)
        })
    }

    render() {

        const isLoading = this.state.isLoading

        return (
            <div className="text-center pt-5">
                <form className="user-form">
                    <img className="mb-4" src={'images/logo.svg'} alt="" width="200" height="72" />
                    <h1 className="h3 mb-3 font-weight-normal">Please sign up</h1>
                    <div className="form-group">
                        <label htmlFor="name" className="sr-only">Name</label>
                        <input
                            id="name"
                            className="form-control"
                            type="text"
                            name="name"
                            placeholder="Enter name"
                            value={this.state.signupData.name}
                            onChange={this.changeHandler}
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="email" className="sr-only">Email</label>
                        <input
                            id="email"
                            className="form-control"
                            type="email"
                            name="email"
                            placeholder="Enter email"
                            value={this.state.signupData.email}
                            onChange={this.changeHandler}
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="password" className="sr-only">Password</label>
                        <input
                            id="password"
                            className="form-control"
                            type="password"
                            name="password"
                            placeholder="Enter password"
                            value={this.state.signupData.password}
                            onChange={this.changeHandler}
                        />
                    </div>
                    <p className="text-white">{this.state.message}</p>
                    <button
                        id="registerBtn"
                        className="btn btn-lg btn-primary btn-block"
                        onClick={this.submitHandler}
                    >
                        Sign Up
                        {isLoading ? (
                            <span
                                className="spinner-border spinner-border-sm ml-5"
                                role="status"
                                aria-hidden="true"
                            />
                        ) : (
                            <span />
                        )}
                    </button>
                    <Link
                        id="goToLoginBtn"
                        className="btn btn-lg btn-block btn-outline-primary"
                        to="/login"
                    >
                        I already have an account.
                    </Link>
                </form>
            </div>
        )
    }
}
