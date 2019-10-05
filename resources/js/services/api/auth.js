import { Axios } from "../../helpers/axios";

export function login(user) {
    return new Promise((res, rej) => {
        Axios.post('/api/auth/login', user)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            })
    })
}

export function register(user) {
    return new Promise((res, rej) => {
        Axios.post('/api/auth/register', user)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            })
    })
}

export function logout() {
    return new Promise((res, rej) => {
        const user = JSON.parse(localStorage.getItem("user"));

        Axios.get('/api/auth/logout')
            .then((response) => {
                res(response.data);
                localStorage.removeItem(user);

            })
            .catch((err) => {
                localStorage.removeItem(user);
                rej("Could not logout");
            })
    })
}
