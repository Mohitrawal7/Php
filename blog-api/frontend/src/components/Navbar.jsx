import api from "../api/axios";
import {Link, useNavigate } from "react-router-dom";

const Navbar = () => {
  const navigate = useNavigate();

  const logout = async () => {
    await api.get("auth/logout.php");
    navigate("/login");
  };

  return (
   <nav className="bg-gray-900 text-white px-6 py-4 flex justify-between items-center">
      <Link to="/" className="text-xl font-semibold">Blog Dashboard</Link>
      <div className="space-x-3">
        <Link
          to="/add"
          className="bg-green-600 hover:bg-green-700 px-4 py-2 rounded"
        >
          Add Blog
        </Link>
        <button
          onClick={logout}
          className="bg-red-600 hover:bg-red-700 px-4 py-2 rounded"
        >
          Logout
        </button>
      </div>
    </nav>
  );
}

export default Navbar;