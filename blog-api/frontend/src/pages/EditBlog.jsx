import { useParams, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import api from "../api/axios";
import Navbar from "../components/Navbar";

const EditBlog = () => {
  const { id } = useParams();
  const nav = useNavigate();
  const [title, setTitle] = useState("");
  const [content, setContent] = useState("");
  const [image, setImage] = useState(null);

  useEffect(() => {
    api.get("posts/get_posts.php").then(res => {
      const post = res.data.find(p => p.id == id);
      if (post) {
        setTitle(post.title);
        setContent(post.content);
      }
    });
  }, [id]);

  const submit = async e => {
    e.preventDefault();
    try {
      const fd = new FormData();
      fd.append("id", id);
      fd.append("title", title);
      fd.append("content", content);
      if (image) fd.append("image", image);

      await api.post("posts/edit_post.php", fd, {
        headers: { "Content-Type": "multipart/form-data" }
      });

      nav("/"); // go back to dashboard
    } catch (err) {
      alert("Failed to update blog");
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
          <h2 className="text-xl font-bold mb-4">Edit Blog</h2>
          <input
            className="w-full border p-2 mb-3 rounded"
            placeholder="Title"
            value={title}
            onChange={e => setTitle(e.target.value)}
            required
          />
          <textarea
            className="w-full border p-2 mb-3 rounded"
            placeholder="Content"
            rows="6"
            value={content}
            onChange={e => setContent(e.target.value)}
            required
          />
          <input
            type="file"
            className="w-full mb-3"
            onChange={e => setImage(e.target.files[0])}
          />
          <button
            className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
          >
            Update
          </button>
        </form>
      </div>
    </>
  );
}


export default EditBlog;    