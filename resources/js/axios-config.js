import axios from "axios";

const token = localStorage.getItem("scantumToken");

// Set the token as a default header for Axios
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
axios.defaults.baseURL = "/api/v1";

export default axios;
