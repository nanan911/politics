import React, { useState } from 'react';

function AnalyzePage() {
  const [loading, setLoading] = useState(false);
  const [showResult, setShowResult] = useState(false);

  const handleButtonClick = () => {
    setLoading(true);
    
    setTimeout(() => {
      setLoading(false);
      setShowResult(true);
    }, 3000);
  };

  return (
    <div>
      {!showResult ? (
        <div className="form-group" style={{width:'1690px', marginTop:'15%',marginBottom:'30%'}}>
          {loading && (
            <img src="load.gif" alt="Loading..." style={{display: 'block', marginTop: '15px', marginLeft: '425px', width: '200px', height: '200px'}} />
          )}
          {!loading && (
            <>
              <input type="text" className="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="請輸入文章" style={{marginLeft:'10%', width:'85%'}}/>
              <button 
                type="button" 
                className="btn btn-primary" 
                style={{marginTop: '45px', marginLeft: '45%', width:'150px', height:'45px', backgroundColor:'#e8c350', borderColor: '#e8c350', fontWeight: 'bold', fontSize: '20px'}} 
                onClick={handleButtonClick}
              >
                一鍵分析
              </button>
            </>
          )}
        </div>
      ) : (
        <div className='analyze'>
          <div className='e1'>
            <h4 style={{ fontWeight: 'bold', margin:'10px'}}>關鍵人物</h4>
            <div className='image-container'>
                <div className='image-item'>
                <img src="person1.jpg" alt="柯文哲" className='person-image'/>
                <div className='image-label'>柯文哲</div>
                </div>
                <div className='image-item'>
                <img src="person2.jpg" alt="高虹安" className='person-image'/>
                <div className='image-label'>高虹安</div>
                </div>
            </div>
            </div>

          <div className='e2'>
            <h4 style={{fontWeight:'bold', margin:'10px'}}>文章主題</h4>
            <h3 style={{fontWeight:'bold', marginTop:'50%', color:'gray'}}>民眾黨</h3>
          </div>
          <div className='e3'> 
            <h4 style={{fontWeight:'bold', margin:'10px'}}>文章情緒</h4>
            <h3 style={{fontWeight:'bold', marginTop:'50%', color:'#02ad58'}}>正面</h3>
          </div>
        </div>
      )}
    </div>
  );
}

export default AnalyzePage;
