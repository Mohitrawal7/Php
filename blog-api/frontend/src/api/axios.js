// src/api.js
import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost/PHP/blog-api/backend/", // your PHP backend folder
  withCredentials: true, // if you plan to use sessions/cookies
  headers: {
    "Content-Type": "application/json",
  },
});

export default api;
