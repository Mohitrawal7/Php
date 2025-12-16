import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import api from "../api/axios";

const Register = () => {
  const [form, setForm] = useState({});
  const nav = useNavigate();

  const submit = async e => {
    e.preventDefault();
    const res = await api.post("auth/register.php", form);
    res.data.success ? nav("/login") : alert(res.data.error);};

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100">
      <form onSubmit={submit} className="bg-white p-6 rounded shadow w-80">
        <h2 className="text-xl font-bold mb-4">Register</h2>
        <input className="w-full border p-2 mb-2 rounded"
          placeholder="Name" onChange={e => setForm({...form, name:e.target.value})}/>
        <input className="w-full border p-2 mb-2 rounded"
          placeholder="Email" onChange={e => setForm({...form, email:e.target.value})}/>
        <input type="password" className="w-full border p-2 mb-3 rounded"
          placeholder="Password" onChange={e => setForm({...form, password:e.target.value})}/>
        <button className="w-full bg-green-600 text-white py-2 rounded">
          Register
        </button>
        <p className="text-sm mt-3">
          Have account? <Link to="/login" className="text-blue-600">Login</Link>
        </p>
      </form>
    </div>
  );
}

export default Register;