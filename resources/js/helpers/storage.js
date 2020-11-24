export const storage = {
    isLoggedIn: validUserKey,
    user,
    token
}

function user() {
    return JSON.parse(localStorage.getItem('user'))
}

function validUserKey() {
    if(!user()) {
        return false
    }

    let expireDate = new Date(user().access_token.expires_at)

    if (expireDate < new Date('now')) {
        localStorage.removeItem('user')

        return false
    }

    return true
}

function token() {
    return (user()) ? user().access_token : undefined
}
