import React, { useState } from 'react';

function AnalyzePage() {
  const [loading, setLoading] = useState(false);
  const [showResult, setShowResult] = useState(false);
  const [analysis, setAnalysis] = useState(null);
  const [error, setError] = useState(null);

  const handleButtonClick = async () => {
    setLoading(true);
    setError(null);
    
    try {
      const response = await fetch('/api/analyze', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ text: '你的測試文本' }), // 根據需求修改文本
      });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const result = await response.json();
      setAnalysis(result);
      setShowResult(true);
    } catch (err) {
      console.error('Error fetching analysis:', err);
      setError('分析過程中出現錯誤');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      {!showResult ? (
        <div className="form-group" style={{width:'1000px', marginLeft: '20%', marginTop:'15%'}}>
          {loading && (
            <img src="load.gif" alt="Loading..." style={{display: 'block', marginTop: '15px', marginLeft: '425px', width: '200px', height: '200px'}} />
          )}
          {!loading && (
            <>
              <input type="text" className="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="請輸入文章" style={{marginLeft:'5%'}}/>
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
            <h3 style={{fontWeight:'bold', marginTop:'50%', color:'gray'}}>{analysis?.topic || 'N/A'}</h3>
          </div>
          <div className='e3'> 
            <h4 style={{fontWeight:'bold', margin:'10px'}}>文章情緒</h4>
            <h3 style={{fontWeight:'bold', marginTop:'50%', color:'#02ad58'}}>{analysis?.sentiment || 'N/A'}</h3>
          </div>
        </div>
      )}
    </div>
  );
}

export default AnalyzePage;
