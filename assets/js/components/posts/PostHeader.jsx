function PostHeader ({ authorAvatar, authorFullname, postDate, profilUrl }) {
  return (
    <div className="post-header">
      <div className="post-author d-flex">
        <a href={profilUrl}><img key={authorAvatar} src={authorAvatar} alt=""/></a>
        <div className="author-name post-date">
          <div key={authorFullname} className="name"><a href={profilUrl}>{authorFullname}</a></div>
          <div key={postDate} className="date">{postDate}</div>
        </div>
      </div>
    </div>
  );
}

export default PostHeader;