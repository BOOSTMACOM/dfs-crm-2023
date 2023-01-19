import React from 'react';

const Counter = ({label, value}) => {
    return (
        <div className="col">
            <div className='card'>
                <div className='card-header'>
                    <h5 className='card-title'>{ label }</h5>
                </div>
                <div className='card-body text-center'>
                    <strong style={{fontSize: '100px'}}>{ value }</strong> 
                </div>
            </div>
        </div>
    );
};

export default Counter;