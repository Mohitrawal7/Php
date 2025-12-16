import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import api from "../api/axios";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();

  const submit = async e => {
  e.preventDefault(); // Prevent page refresh
  try {
    console.log("Submitting login", { email, password });
    const res = await api.post("auth/login.php", { email, password });

    if (res.data.success) {
      navigate("/"); // Redirect to dashboard after login
    } else {
      alert(res.data.error);
    }
  } catch (err) {
    console.error(err);
    alert("Something went wrong. Check console.");
  }
};


  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100">
      <form
        onSubmit={submit}
        className="bg-white p-6 rounded shadow w-80"
      >
        <h2 className="text-xl font-bold mb-4">Login</h2>
        <input
          className="w-full border p-2 mb-3 rounded"
          placeholder="Email"
          onChange={e => setEmail(e.target.value)}
        />
        <input
          type="password"
          className="w-full border p-2 mb-3 rounded"
          placeholder="Password"
          onChange={e => setPassword(e.target.value)}
        />
        <button className="w-full bg-blue-600 text-white py-2 rounded">
          Login
        </button>
        <p className="text-sm mt-3">
          No account? <Link to="/register" className="text-blue-600">Register</Link>
        </p>
      </form>
    </div>
  );
}

export default Login;