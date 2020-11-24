import { createStore } from 'redux'

let user = JSON.parse(localStorage.getItem('user'))
const initialState = user ? { isLoggedIn: true, user } : {}

const store = createStore((state = initialState, action) => {
    switch (action.type) {
        case 'LOGIN_SUCCESS':
            return {
                isLoggedIn: true,
                user: action.user
            }
        case 'LOGIN_FAILURE':
            return {
                isLoggedIn: false,
                user: undefined
            }
        case 'REGISTER_SUCCESS':
            return {
                isLoggedIn: true,
                user: action.user
            }
        case 'REGISTER_FAILURE':
            return {
                isLoggedIn: false,
                user: undefined
            }
        case 'LOGOUT':
            return {
                isLoggedIn: false,
                user: undefined
            }
        default:
            return state
    }
})

export default store
