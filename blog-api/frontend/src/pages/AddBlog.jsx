import { useState } from "react";
import api from "../api/axios";
import { useNavigate } from "react-router-dom";
import Navbar from "../components/Navbar";

const AddBlog = () => {
  const [title, setTitle] = useState("");
  const [content, setContent] = useState("");
  const [image, setImage] = useState(null);
  const nav = useNavigate();

  const submit = async e => {
    e.preventDefault();
    try {
      const fd = new FormData();
      fd.append("title", title);
      fd.append("content", content);
      if (image) fd.append("image", image);

      await api.post("posts/add_post.php", fd, {
        headers: { "Content-Type": "multipart/form-data" }
      });

      nav("/"); // go back to dashboard
    } catch (err) {
      alert("Failed to add blog");
    }
  };

  return (
    <>
      <Navbar />
      <div className="p-6 bg-gray-100 min-h-screen flex justify-center">
        <form
          onSubmit={submit}
          className="bg-white p-6 rounded shadow w-full max-w-lg"
        >
          <h2 className="text-xl font-bold mb-4">Add New Blog</h2>
          <input
            className="w-full border p-2 mb-3 rounded"
            placeholder="Title"
            required
            onChange={e => setTitle(e.target.value)}
          />
          <textarea
            className="w-full border p-2 mb-3 rounded"
            placeholder="Content"
            rows="6"
            required
            onChange={e => setContent(e.target.value)}
          />
          <input
            type="file"
            className="w-full mb-3"
            onChange={e => setImage(e.target.files[0])}
          />
          <button
            className="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
          >
            Publish
          </button>
        </form>
      </div>
    </>
  );
}

export default AddBlog;