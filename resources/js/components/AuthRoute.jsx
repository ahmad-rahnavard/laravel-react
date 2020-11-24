import React from 'react'
import { Redirect, Route } from 'react-router-dom'
import { storage } from '../helpers/storage'

const AuthRoute = ({ component: Component, ...rest }) => (
    <Route {...rest} render={props => (
        storage.isLoggedIn()
            ? <Redirect to={{ pathname: '/', state: { from: props.location } }} />
            : <Component {...props} />
    )} />
)

export default AuthRoute
