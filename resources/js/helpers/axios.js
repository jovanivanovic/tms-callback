import _axios from "axios";
import authHeader from "./auth-header";

export const Axios = _axios.create({
    headers: authHeader()
});