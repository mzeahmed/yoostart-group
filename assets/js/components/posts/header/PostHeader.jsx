import moment from 'moment';

function PostHeader ({ author, date }) {
  let url = author.profile_url ?? author.profile_url;
  let avatar = author.avatar_image ?? author.avatar_image;
  console.log(url);

  return (
    <div className="post-header">
      <div className="post-author d-flex">
        <a href={url}><img src={avatar} alt=""/></a>
        <div className="author-name post-date">
          <div className="name"><a href={url}>{author.fullname}</a></div>
          <div className="date">{moment(date).fromNow()}</div>
        </div>
      </div>
    </div>
  );
}

export default PostHeader;