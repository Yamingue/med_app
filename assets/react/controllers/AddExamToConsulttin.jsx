import React, { useRef } from 'react'


export default function ({ id = -1, url }) {
    console.log(id)
    const [exams, setExams] = React.useState([])
    const [sending, setSending] = React.useState(false)
    const [selectedExam, setSelectedExam] = React.useState([

    ])
    const query = (data) => {
        console.log(data.target.value)
        if (data.target.value != "") {
            fetch('/api/exament', {
                method: 'POST',
                body: JSON.stringify({
                    "query": data.target.value
                })
            }).then(d => d.json())
                .then(json => {
                    console.log(json)
                    setExams(json)
                })
        } else {
            setExams([])
        }
    }

    const addExam = (exam) => {
        console.log(exam)
        let exament = selectedExam.filter(e => e.id != exam.id)
        console.log(exament)
        setSelectedExam([...exament, exam])
        // setExams([])
        // inputRef.current.value = ""
    }

    const removeExam = (exam) => {
        let exament = selectedExam.filter(e => e.id != exam.id)
        setSelectedExam([...exament])
        // inputRef.current.value = ""
    }

    const sendExam = () => {
        setSending(true)
        fetch('/api/exament_add/consultation/' + id, {
            method: 'POST',
            body: JSON.stringify({
                "examts": selectedExam
            })
        }).then(d => d.json())
            .then(json => {
                console.log(json)
                // setExams([])
                // inputRef.current.value = ""
                window.location.href = url
            })
    }

    return <>
        <div className="input-group">
            <span className="input-group-text" id="basic-addon11">
                <i className='bx bx-search-alt-2'></i>
            </span>
            <input onChange={query} type="text" className="form-control" placeholder="Rechercher" aria-label="Username" aria-describedby="basic-addon11" />
        </div>

        {
            exams.map((exam) => {
                return <div key={exam.id} className="card mt-2">
                    <div className="d-flex justify-content-between" style={{ margin: '10px' }}>
                        <div>
                            <strong>{exam.nom}</strong>  <br />
                            <span>{exam.prix} XFA</span>
                        </div>
                        <button onClick={e => {
                            addExam(exam)
                        }} className="btn btn-success btn-icon rounded-pill">
                            <i class='bx bxs-plus-circle' ></i>
                        </button>
                    </div>
                </div>
            })
        }

        <div className="card mt-3">

            <div className="card-body">
                <h4>
                    Exament a faire
                </h4>
                <table className="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Actin</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            selectedExam.map(el => <tr key={el.id}>
                                <th scope="row">{el.id}</th>
                                <td>{el.nom}</td>
                                <td>{el.prix}</td>
                                <td>
                                    <button onClick={e => removeExam(el)} type="button" className="btn btn-danger btn-icon rounded-pill">
                                        <i className='bx bx-x-circle' ></i>
                                    </button>
                                </td>
                            </tr>)
                        }
                    </tbody>
                </table>
                <button onClick={sendExam} disabled={selectedExam.length <= 0 || sending} className="btn btn-primary mt-2">
                    {
                        sending ? "...Envoie en cours" : "Valider"
                    }
                </button>
            </div>
        </div>
    </>
}