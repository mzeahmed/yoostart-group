function PostHeader ({ authorAvatar, authorFullname, postDate, profilUrl }) {
  return (
    <div className="post-header">
      <div className="post-author d-flex">
        <a href={profilUrl}><img src={authorAvatar} alt=""/></a>
        <div className="author-name post-date">
          <div className="name"><a href={profilUrl}>{authorFullname}</a></div>
          <div className="date">{postDate}</div>
        </div>
      </div>
    </div>
  )
}

export default PostHeader